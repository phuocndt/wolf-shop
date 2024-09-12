<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * The function registers a new user by validating input data, creating a user record, generating an access token,
     * and returning a JSON response.
     *
     * @param Request $request The `register` function you provided is a typical implementation for user registration
     * in a Laravel application. It validates the incoming request data, creates a new user if the validation passes,
     * and generates a token for the user using Laravel Sanctum for API authentication.
     *
     * @return The `register` function returns a JSON response with different data based on the outcome of the
     * registration process.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'email' => 'required|string|unique:users|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $token = $user->createToken('register_token')->plainTextToken;
            return response()->json([
                'status' => Response::HTTP_OK,
                'data' => $user,
                'access_token' => $token,
                'type' => 'Bearer',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * The function handles user login authentication, validation, and token generation in a PHP Laravel application.
     *
     * @param Request $request The `login` function you provided is a typical implementation for handling user
     * authentication in a Laravel application. Let's break down the code and explain each part:
     *
     * @return The `login` function returns a JSON response with the following structure:
     * - If validation fails, it returns the validation errors.
     * - If authentication fails (invalid credentials), it returns a JSON response with status code 401 (Unauthorized)
     * and a message indicating 'Invalid credentials'.
     * - If authentication is successful, it returns a JSON response with status code 200 (OK) containing:
     *   - 'Login success
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if (! Auth::attempt($credentials)) {
            if (! $user || ! Hash::check($request['password'], $user->password)) {
                return response()->json([
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'Invalid credentials',
                ], Response::HTTP_UNAUTHORIZED);
            }
        }

        $token = $user->createToken('login_token')->plainTextToken;
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Login success',
            'data_user' => $request->user(),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], Response::HTTP_OK);
    }

    /**
     * The `logout` function deletes the user's tokens and returns a JSON response indicating successful logout.
     *
     * @return A JSON response with a status code of 200 (HTTP_OK) and a message indicating that the logout was
     * successful.
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Logout success',
        ], Response::HTTP_OK);
    }
}
