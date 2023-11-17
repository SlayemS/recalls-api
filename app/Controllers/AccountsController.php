<?php

namespace Vanier\Api\Controllers;

use Fig\Http\Message\StatusCodeInterface as HttpCodes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\JWTManager;
use Vanier\Api\Models\AccountsModel;

/**
 * A controller class that handles requests for creating new account and 
 * generating JWTs.
 * 
 * @author frostybee
 */
class AccountsController extends BaseController
{
    private $accounts_model = null;

    private $rules_create = array(
        'first_name' => [
            'required',
            ['lengthMax', 100]
        ],
        'last_name' => [
            'required',
            ['lengthMax', 150]
        ],
        'email' => [
            'required',
            ['lengthMax', 150]
        ],
        'password' => [
            'required',
            ['lengthMax', 255]
        ],
        'role' => [
            'required',
            ['lengthMax', 10],
        ],
        'created_at' => [
            'required',
            'integer',
            ['min', 1],
        ],
    );

    public function __construct()
    {
        $this->accounts_model = new AccountsModel();
    }
    public function handleCreateAccount(Request $request, Response $response)
    {
        $account_data = $request->getParsedBody();
        // 1) Verify if any information about the new account to be created was included in the 
        // request.
        if (empty($account_data)) {
            return $this->prepareOkResponse($response, ['status'=> "failed", 'message' => 'No data was provided in the request.'], 400);
        }
        $validation_response = $this->isValidData($account_data, $this->rules_create);
        if ($validation_response === false) {
            $response_data = array(
                "code" => 422,
                "message" => $validation_response
            );
            return $this->prepareOkResponse(
                $response,
                $response_data,
                HttpCodes::STATUS_UNPROCESSABLE_ENTITY
            );
        }
        if ($this->accounts_model->isAccountExist($account_data['email'])) { // Check if email already in use
            return $this->prepareOkResponse($response, ['error'=> true, 'message'=> 'Email is already in use.'], 422);
        }

        //TODO: before creating the account, verify if there is already an existing one with the provided email.
        // 2) Data was provided, we attempt to create an account for the user.                
        $account = $this->accounts_model->createAccount($account_data);

        
        // 3) A new account has been successfully created. 
        // Prepare and return a response.  
        $response_data = array(
            "code" => HttpCodes::STATUS_CREATED,
            "message" => "Account has been created"
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_CREATED
        );
    }

    public function handleGenerateToken(Request $request, Response $response, array $args)
    {
        $account_data = $request->getParsedBody();
        //var_dump($user_data);exit;

        //-- 1) Reject the request if the request body is empty.
        if (empty($account_data)) {
            return $this->prepareOkResponse($response, ['status'=> "failed", 'message' => 'No data was provided in the request.'], 422);
        }

        //-- 2) Retrieve and validate the account credentials.
        if (empty($account_data['email']) || empty($account_data['password'])) {
            return $this->prepareOkResponse($response, ['status'=> "failed", 'message' => 'Email or password cannot be empty.'], 422);
        }

        //-- 3) Is there an account matching the provided email address in the DB?
        $fetched_account_data = $this->accounts_model->isAccountExist($account_data['email']);
        if ($fetched_account_data) {
            
            //-- 4) If so, verify whether the provided password is valid.
            if ($this->accounts_model->isPasswordValid($account_data['email'], $account_data['password'])) {
                return $this->prepareOkResponse($response, ['status'=> "failed", 'message'=> 'Account credentials incorrect.'], 401);
            }

        } else {
            return $this->prepareOkResponse($response, ['status'=> "failed", 'message'=> 'Account does not exist.'], 422);
        }

        //-- 5) Valid account detected => Now, we return an HTTP response containing
        // the newly generated JWT.
        // TODO: add the account role to be included as JWT private claims.
        //-- 5.a): Prepare the private claims: user_id, email, and role.
        $data_for_token = array($fetched_account_data["user_id"], $fetched_account_data["email"], $fetched_account_data["role"]);

        // Current time stamp * 60 seconds        
        $expires_in = time() + 60 * 60; //! NOTE: Expires in 1 minute.
        //!note: the time() function returns the current timestamp, which is the number of seconds since January 1st, 1970
        //-- 5.b) Create a JWT using the JWTManager's generateJWT() method.
        $jwt = JWTManager::generateJWT($data_for_token, $expires_in);
        //--
        // 5.c) Prepare and return a response with a JSON doc containing the jwt.
        $response_data = array(
            "status"=>"success",
            "token"=>$jwt,
            "message"=>"Logged in successfully!"
        );

        return $this->prepareOkResponse(
            $response,
            $response_data,
            HttpCodes::STATUS_CREATED
        );
    }
}
