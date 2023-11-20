<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UserConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddUserRequest;
use App\Models\Admin\Role;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HRMController extends Controller
{
    private const PER_PAGE = 10;

    public function __construct()
    {
    }

    // ---------------- Danh mục quan lý user ------------------//

    //-- Mục List user
    public function listUser(Request $request)
    {
        $perPage = $request->input('perPage', self::PER_PAGE);
        $page = request()->query('page', 1);

        $users = User::paginate($perPage, ['*'], 'page', $page);

        return view('Backend.HRM.User.list', [
            'title' => 'Admin - list user',
            'titleHeader' => 'Danh sách nhân viên',
            'users' => $users
        ]);
    }
    // -- Mục Show user
    public function detailUser(int $id)
    {
        $user = User::where('id', $id)->first();
        if (empty($user)) {
            session()->flash('error', 'Không tìm thấy user trong database');
            return redirect()->route('users/list');
        } else {
            return view('Backend.HRM.User.detail', [
                'user' => $user,
                'title' => 'Admin - Thông tin nhân viên',
                'titleHeader' => 'Thông tin nhân viên ' . $user->name,
            ]);
        }
    }

    //-- Mục Add user
    public function showAddUser()
    {
        return view('Backend.HRM.User.add', [
            'roles' => Role::all(),
            'accessLoginList' => UserConstant::getListAccessLogin(),
            'title' => 'Admin - add user',
            'titleHeader' => 'Form Nhân viên'
        ]);
    }
    public function submitAddUser(AddUserRequest $request)
    {
        $data = [
            'id' => $this->getIdAsTimestamp(),
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'birth' => $request->input('birth'),
            'gender' => $request->input('gender'),
            'updated_by' => Auth::user()->id,
            'access_login' => $request->input('access_login'),
        ];
        $user = User::create($data);
        if ($user) {
            $roleId = $request->input('role');
            // Liên kết vai trò với người dùng mới
            $user->role()->attach($roleId);
            session()->flash('success', 'Lưu trữ dữ liệu thành công!');
            return redirect()->route('users/list');
        } else {
            session()->flash('error', 'Có lỗi gì đó khi inset database');
            return redirect()->back()->withInput();
        }
    }

    /**
     * -- Mục Edit user
     */
    public function showEditUser(int $id)
    {
        $user = User::where('id', $id)->first();
        if (empty($user)) {
            session()->flash('error', 'Không tìm thấy user trong database');
            return redirect()->route('users/list');
        } else {
            return view('Backend.HRM.User.edit', [
                'user' => $user,
                'roles' => Role::all(),
                'accessLoginList' => UserConstant::getListAccessLogin(),
                'title' => 'Admin - edit user',
                'titleHeader' => 'Edit nhân viên ' . $user->name
            ]);
        }
    }

    public function submitEditUser(Request $request, $userId)
    {
        $user = User::find($userId);
        if (!$user) {
            session()->flash('error', 'Không tìm thấy người dùng!');
            return redirect()->route('users/list');
        }
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'email', Rule::unique('user')->ignore($user->id)],
                'name' => 'required',
                'address' => 'required|max:255',
                'phone' => 'required|numeric',
                'birth' => 'required|date',
                'gender' => 'required|in:1,2',
                'role' => 'required',
                'access_login' => 'required',
            ],
            [
                'email.required' => 'Vui lòng nhập địa chỉ email.',
                'email.email' => 'Địa chỉ email không hợp lệ.',
                'email.unique' => 'Địa chỉ email đã tồn tại trong hệ thống.',
                'name.required' => 'Vui lòng nhập tên.',
                'address.required' => 'Vui lòng nhập địa chỉ.',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
                'phone.required' => 'Vui lòng nhập số điện thoại.',
                'phone.numeric' => 'Số điện thoại phải là số.',
                'birth.required' => 'Vui lòng nhập ngày sinh.',
                'birth.date' => 'Ngày sinh không hợp lệ.',
                'gender.required' => 'Vui lòng chọn giới tính.',
                'gender.in' => 'Giới tính không hợp lệ.',
                'role.required' => 'Vui lòng chọn vai trò của người dùng.',
                'access_login.required' => 'Vui lòng chọn quyền truy cập đăng nhập.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->birth = $request->input('birth');
        $user->gender = $request->input('gender');
        $user->access_login = $request->input('access_login');
        $user->updated_by = Auth::user()->id;
        $updateResult = $user->save();

        if ($updateResult) {
            $roleId = $request->input('role');
            // Sử dụng sync để cập nhật mối quan hệ
            $user->role()->sync([$roleId]);
            session()->flash('success', 'Lưu trữ dữ liệu thành công!');
            return redirect()->route('users/list');
        } else {
            session()->flash('error', 'Có lỗi gì đó khi update database');
            return redirect()->back()->withInput();
        }
    }


    /**
     * // ---------------- Danh mục quan lý role ------------------//
     */

    public function listRole(Request $request)
    {
        $perPage = $request->input('perPage', self::PER_PAGE);
        $page = request()->query('page', 1);

        $roleData = Role::paginate($perPage, ['*'], 'page', $page);

        return view('Backend.HRM.Role.list', [
            'title' => 'Admin - list roles',
            'titleHeader' => 'Danh sách Role',
            'roles' => $roleData
        ]);
    }

    public function formRegisterRole(Request $request)
    {
        return view('Backend.HRM.add-role', [
            'title' => 'Admin - add roles',
            'titleHeader' => 'Thêm Role',
        ]);
    }

    public function registerRole(Request $request)
    {
        $request->validate([
            'title' => 'required|min:4|max:50',
            'description' => 'required|max:255',
        ]);
        $result = Role::create([
            'id' => $this->getIdAsTimestamp(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'updated_by' => Auth::user()->id
        ]);
        if ($result) {
            session()->flash('success', 'Lưu trữ dữ liệu thành công!');
            return redirect()->route('users/list-role');
        } else {
            session()->flash('error', 'Có lỗi gì đó khi inset database');
            return redirect()->back()->withInput();
        }
    }
}
