<?php

use Firebase\JWT\JWT;
// // use Firebase\JWT\Key;
use Rakit\Validation\Validator;



class Auth extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (array)requestData();
            if ($post !== null) {

                /* #region(collapsed) validate data */
                $validator = new Validator;
                $validation = $validator->make($post, [
                    'mobile'               => "required|numeric",
                    'password'             => 'required|min:8'
                ], [
                    'required' => 'این مورد اجباری است',
                    'min' => 'حد اقل کارکتر ورودی 8 کارکتر',
                    'regex' => 'الگوی ورودی صحیح نیست',
                    'numeric' => 'فقط مجاز به ورود اعداد هستید'
                ]);

                $validation->validate();

                if ($validation->fails()) {
                    $errors = $validation->errors();
                    echo json_encode([
                        'message' => $errors->firstOfAll(':message', true),
                        'success' => false,
                    ]);
                    die;
                }
        /* #endregion */

                /* #region(collapsed) login */
                $users = DB::query("SELECT * FROM users WHERE mobile = :mobile", [
                    ":mobile" => $post['mobile']
                ]);

                if (sizeof($users) == 0) {
                    echo json_encode([
                        'message' => 'کاربر با این مشخصات یافت نشد',
                        'success' => false,
                    ]);
                    die;
                } else {
                    $user = $users[0];
                    $passOk = password_verify($post['password'], $user['password']);
                    if (!$passOk) {
                        echo json_encode([
                            'message' => 'پسوورد نادرست',
                            'success' => false,
                        ]);
                        die;
                    } else {
                        try {
                            $iat = time();
                            $exp = $iat + 3600;
                            $payload = [
                                'iat' => $iat,
                                'exp' => $exp
                            ];
                            $key = "";
                            $jwt = JWT::encode($payload, $key, 'HS512');
                            // $decoded = JWT::decode($jwt, new Key($this->key, 'HS512'));
                            DB::query("INSERT INTO tokens (user_id, token, exp) VALUES(:user_id, :token, :exp)", [
                                ':user_id' => $user['id'],
                                ':token' => $jwt,
                                ':exp' => $exp
                            ]);

                            echo json_encode([
                                'success' => true,
                                'token' => $jwt,
                                'expire_time' => $exp,
                                'token_type' => 'Bearer',
                            ]);
                        } catch (\Exception $e) {
                            apiError($e);
                        }
                    }
                }
                /* #endregion */
            
            } else {
                apiError('please pill in all the credentials');
            }
        } else {
            apiError('Method not allowed');
        }
    }

    public function register()
    {
        /* #region(collapsed) register method */
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (array)requestData();
            if ($post !== null) {
                //validate data==================            
                $validator = new Validator;
                $validation = $validator->make($post, [
                    'user_name'             => 'required|alpha_dash',
                    'email'                 => "email",
                    'password'              => 'required|min:8',
                    'confirm_password'      => 'required|same:password',
                    'first_name' => 'regex:/^[ابپتثجچهخدذرزسشصظطضعغفقک@-_.:گلمنوهیژئي\s0-9a-zA-Z]+$/ ',
                    'last_name' => 'regex:/^[ابپتثجچهخدذرزسشصظطضعغفقک@-_.:گلمنوهیژئي\s0-9a-zA-Z]+$/',
                    'mobile' => "required|numeric",
                    'gender' => 'numeric|max:2',
                    // 'avatar' => 'uploaded_file:0,500K,png,jpeg',
                ], [
                    'required' => 'این مورد اجباری است',
                    'email:email' => 'الگوی ورودی ایمیل را بررسی کنید',
                    'min' => 'حد اقل کارکتر ورودی 8 کارکتر',
                    'max' => 'حد اکثر کارکتر ورودی 2 عدد',
                    'same' => 'باید مشابه رمز عببور باشد',
                    'alpha_dash' => 'فقط حروف لاتین و اعداد و خط تیره ',
                    'regex' => 'الگوی ورودی صحیح نیست',
                    'numeric' => 'فقط مجاز به ورود اعداد هستید',
                    'uploaded_file' => 'فایل ورودی مجاز نیست'
                ]);

                $validation->validate();

                if ($validation->fails()) {
                    $errors = $validation->errors();
                    echo json_encode([
                        'message' => $errors->firstOfAll(':message', true),
                        'success' => false,
                    ]);
                    die;
                }

                // check is exist user ==================
                $oldUser = DB::query("SELECT * FROM users WHERE user_name = :user_name OR mobile = :mobile ", [
                    ':user_name' => $post['user_name'],
                    ":mobile" => $post['mobile']
                ]);

                if (sizeof($oldUser) > 0) {
                    $RepetitiousItem = $oldUser[0]['user_name'] == $post['user_name'] ? 'نام کاربری' : 'شماره موبایل';
                    echo json_encode([
                        'message' => "$RepetitiousItem تکراری است",
                        'success' => false,
                    ]);
                    die;
                }

                // store user ==================
                DB::query("INSERT INTO users (user_name, first_name, last_name, email, mobile, password, gender) VALUES(:user_name, :first_name, :last_name, :email, :mobile, :password, :gender)", [
                    ':user_name' => $post['user_name'],
                    ':first_name' => isset($post['first_name']) ? $post['first_name'] : "",
                    ':last_name' => isset($post['last_name']) ? $post['last_name'] : "",
                    ':email' => isset($post['email']) ? $post['email'] : "",
                    ':mobile' => $post['mobile'],
                    ':password' => password_hash($post['password'], PASSWORD_DEFAULT),
                    ':gender' => isset($post['gender']) ? $post['gender'] : "",
                ]);
                echo json_encode([
                    'message' => 'کاربر با موفقیت ایجاد شد',
                    'success' => true,
                ]);
            } else {
                apiError('please pill in all the credentials');
            }
        } else {
            apiError('Method not allowed');
        }
        /* #endregion */
    }
}
