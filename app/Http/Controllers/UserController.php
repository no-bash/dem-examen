<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Validator;
    use Auth;
    use DB;

    class UserController extends Controller {
        public function profile_page() {
            if (!Auth::check()) return redirect("/")->withErrors('Вы не авторизованы', 'message');

            $user_id = Auth::id();
            $app = DB::table('application')->where("user_id", $user_id)->orderby('created_at', 'DESC')->get();

            $categories = DB::table('categories')->get();

            return view('profile', [
                'app' => $app,
                'categories' => $categories
            ]);
        }

        public function app_add(Request $request) {
            if (!Auth::check()) return redirect("/")->withErrors('Вы не авторизованы', 'message');

            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpeg,jpg,bpm,png|max:10024',
            ]);

            if($validator->fails()) {
                return redirect('/profile')->withErrors('Файл должен быть jpeg,jpg,bpm,png размером 10 МБ', 'message');
            }

            $image_name = "1_" . time() . "_" . rand() . "." . $request->file("image")->extension();
            $request->file("image")->move(public_path("assets/images/before/"), $image_name);
            $path = 'images/before/' . $image_name;
            
            DB::table("application")->insert([
                'user_id' => Auth::id(),
                'title' => $request->input("title"),
                'description' => $request->input("description"),
                'category' => $request->input("category"),
                'path_img_before' => $path,
                'status' => "Новая",
            ]);

            return redirect("/profile")->withErrors('Заявка добавлена', 'message');
        }
        

        public function app_delete($app_id) {
            if (!Auth::check()) return redirect("/")->withErrors('Вы не авторизованы', 'message');

            if(!$app == DB::table("application")->where('application_id', $app_id)->first())
                return redirect("/profile")->withErrors('Такой заявки не существует', 'message');

            if ($app->status !== 'Новая') 
                return redirect("/profile")->withErrors('Можно удалять заявку со статусом новая', 'message');

            if (Auth::user()->id !== $app->user_id) {
                return redirect("/profile")->withErrors('Это не ваша заявка', 'message');
            }

            DB::table("application")->where('application_id', $app_id)->delete();

            return redirect("/profile")->withErrors('Заявка Удалена', 'message');
        }
    }
?> 