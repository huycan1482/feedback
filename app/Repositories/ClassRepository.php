<?php

namespace App\Repositories;

use App\ClassRoom;
use App\Course;
use App\FeedBack;
use App\Lesson;
use App\Repositories\EloquentRepository;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class ClassRepository extends EloquentRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\ClassRoom::class;
    }

    public function createLessons($courseTotalLessons, $latestClass, $data, $time_limit)
    {
        DB::beginTransaction();

        try {
            $day = 0;
            $i = 0;

            while ($i < $courseTotalLessons) {
                // Viết vòng lặp while tạo các buổi học 
                foreach ($data as $key => $item) {
                    // Lặp để lấy thông tin vủa từng buổi học

                    if ($i == $courseTotalLessons) {
                        break;
                        // kiểm tra xem đã đủ số lượng buổi học
                    }

                    $itemDay = date($item);
                    $newDate = strtotime("+" . $day . " day", strtotime($itemDay));

                    $lesson = new Lesson;

                    $lesson->start_at = date('Y-m-d H:i:s', $newDate);
                    $lesson->time_limit = $time_limit;
                    $lesson->class_id = $latestClass;
                    $lesson->is_active = 1;

                    $lesson->save();

                    $i++;
                }
                $day += 7;
            };

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    public function updateLessons($id, $time_limit)
    {
        try {
            $class = $this->_model->find($id);

            $class->lessons()->update([
                'time_limit' => $time_limit,
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function createFeedbacks(array $data, $id)
    {
        try {
            $class = $this->_model->find($id);

            $countBefore = $this->_model->feedback()->count();

            $class->feedback()->attach($data, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_active' => 0,
            ]);
            // lưu dữ liệu vào bảng trung gian qua attach

            $countAfter = $this->_model->feedback()->count();

            return ($countBefore < $countAfter) ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getTeachers()
    {
        try {
            return User::select('users.*')
                ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
                ->where('roles.name', '=', 'teacher')
                ->latest()->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getFeedbacks ()
    {
        try {
            return FeedBack::where('is_active', '=', 1)->latest()->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getCourses ()
    {
        try {
            return Course::where('is_active', '=', 1)->latest()->get();
        } catch (Exception $e) {
            return [];
        }
    }

    public function showModel($id) 
    {
        try {
            return ClassRoom::selectRaw('users.id as id, users.name as name')
                ->leftJoin('user_class', 'classes.id', '=', 'user_class.class_id')
                ->leftJoin('users', 'users.id', '=', 'user_class.user_id')
                ->where('classes.id', $id)
                ->get();
        } catch (Exception $e) {
            return [];
        }
    }
}
