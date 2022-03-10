<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Validator;
    use Auth;
    use DB;

    class AdminController extends Controller {
        public function admin_page() {
            if (!Auth::check()) return redirect("/")->withErrors('Вы не авторизованы', 'message');

            if(Auth::user()->role !== 'admin') return redirect("/")->withErrors('Вы не администратор', 'message');

            $categories = DB::table('categories')->get();

            $new = DB::table('application')->where("status", 'Новая')->orderby('created_at', 'DESC')->get();
            $approved = DB::table('application')->where("status", 'Одобрена')->orderby('created_at', 'DESC')->get();
            $rejected = DB::table('application')->where("status", 'Отклонена')->orderby('created_at', 'DESC')->get();

            return view('admin', [
                'new' => $new,
                'approved' => $approved,
                'rejected' => $rejected,
                'categories' => $categories
            ]);
        }

        public function category_add(Request $request) {
            if (!Auth::check()) return redirect("/")->withErrors('Вы не авторизованы', 'message');
            if(Auth::user()->role !== 'admin') return redirect("/")->withErrors('Вы не администратор', 'message');
            DB::table('categories')->insert([
                'category' => $request->input('category')
            ]);
            return redirect("/admin/")->withErrors('Категория добавлена', 'message');
        }

        public function category_delete(Request $request) {
            if (!Auth::check()) return redirect("/")->withErrors('Вы не авторизованы', 'message');
            if(Auth::user()->role !== 'admin') return redirect("/")->withErrors('Вы не администратор', 'message');

            $category = DB::table('categories')->where('category_id', $request->input('category_id'))->first();
            DB::table('application')->where('category',  $category->category)->delete();
            DB::table('categories')->where('category_id', $request->input('category_id'))->delete();
            return redirect("/admin/")->withErrors('Категория удалена', 'message');
        }


        public function app_approve(Request $request) {
            if (!Auth::check()) return redirect("/")->withErrors('Вы не авторизованы', 'message');
            if(Auth::user()->role !== 'admin') return redirect("/")->withErrors('Вы не администратор', 'message');
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpeg,jpg,bpm,png|max:10024',
            ]);

            if ($validator->fails()) return redirect("/admin/")->withErrors('Файл не корректный', 'message');

            $image_name = "1_" . time() . "_" . rand() . "." . $request->file("image")->extension();
            $request->file('image')->move(public_path('assets/images/after/'), $image_name);
            $path = 'images/after/'.$image_name;
            DB::table('application')->where('application_id', $request->input('app_id'))->update([
                'status' => 'Одобрена',
                'path_img_after' => $path,
            ]);
            return redirect("/admin/")->withErrors('Статус заявки изменен', 'message');
        }

        public function app_reject(Request $request) {
            if (!Auth::check()) return redirect("/")->withErrors('Вы не авторизованы', 'message');
            if(Auth::user()->role !== 'admin') return redirect("/")->withErrors('Вы не администратор', 'message');
            DB::table('application')->where('application_id', $request->input('app_id'))->update([
                'status' => 'Отклонена',
                'rejection_reason' => $request->input('rejected_reason')
            ]);
            return redirect("/admin/")->withErrors('Статус заявки изменен', 'message');
        }
    }
?> 