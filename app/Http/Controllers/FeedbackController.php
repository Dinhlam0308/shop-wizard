<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    // === Hiển thị danh sách phản hồi (cho admin) ===
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $feedbacks = DB::table('feedbacks')->when($search, function ($query, $search) {
                return $query->where('id', $search);
            })->paginate(10);
            return view("admin.feedback.index", compact("feedbacks"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load feedbacks: ' . $e->getMessage()]);
        }
    }

    // === Hiển thị form tạo mới (nếu admin muốn thêm tay) ===
    public function create()
    {
        try {
            return view("admin.feedback.create");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load feedback form: ' . $e->getMessage()]);
        }
    }

    // === Lưu phản hồi từ người dùng (form ở footer) ===
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'message' => 'required|string|max:1000',
                'rating' => 'nullable|integer|min:1|max:5',
            ]);

            $validated = $validator->validate();

            Feedback::create($validated);

            return redirect()->back()->with('success', 'Thank you for your feedback!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to submit feedback: ' . $e->getMessage()]);
        }
    }

    // === Hiển thị chi tiết phản hồi ===
    public function show(string $id)
    {
        try {
            $feedback = Feedback::findOrFail($id);
            return view("admin.feedback.show", compact("feedback"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load feedback details: ' . $e->getMessage()]);
        }
    }

    // === Hiển thị form chỉnh sửa ===
    public function edit(string $id)
    {
        try {
            $feedback = Feedback::findOrFail($id);
            return view("admin.feedback.edit", compact("feedback"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load feedback for editing: ' . $e->getMessage()]);
        }
    }

    // === Cập nhật phản hồi (admin chỉnh sửa) ===
    public function update(Request $request, string $id)
    {
        try {
            $feedback = Feedback::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'message' => 'required|string|max:1000',
                'rating' => 'nullable|integer|min:1|max:5',
            ]);

            $validated = $validator->validate();

            $feedback->update($validated);

            return redirect()->route('admin.feedback.index')
                ->with('success', 'Feedback updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update feedback: ' . $e->getMessage()])
                ->withInput();
        }
    }

    // === Xóa phản hồi ===
    public function destroy(string $id)
    {
        try {
            $feedback = Feedback::findOrFail($id);
            $feedback->delete();

            return redirect()->route('admin.feedback.index')
                ->with('success', 'Feedback deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete feedback: ' . $e->getMessage()]);
        }
    }
}
