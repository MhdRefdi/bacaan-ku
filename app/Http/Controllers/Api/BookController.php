<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;

class BookController extends Controller
{
    private $BookModel;

    public function __construct(Book $BookModel)
    {
        $this->BookModel = $BookModel;
    }

    public function index()
    {
        try {
            $data = $this->BookModel->all();
            return ApiFormatter::Blueprint(200, 'Success', $data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiFormatter::Blueprint(404, 'Data not found');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $message = [
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ];
            return ApiFormatter::Blueprint(422, $message);
        } catch (\Exception $e) {
            report($e);
            return ApiFormatter::Blueprint($e->getCode() == 0 ? 500 : ($e->getCode() != 23000 ? $e->getCode() : 500), 'Proses data gagal, silahkan coba lagi');
        }
    }

    public function store(StoreRequest $request)
    {
        \DB::beginTransaction();
        try {
            $request->image->store('/image/books/');
            $datas = $request->all();
            $datas['image'] = $request->image->hashName();

            $data = $this->BookModel->create($datas);
            \DB::commit();
            return ApiFormatter::Blueprint(200, 'Success', $data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \DB::rollback();
            return ApiFormatter::Blueprint(404, 'Data not found');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollback();
            $message = [
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ];
            return ApiFormatter::Blueprint(422, $message);
        } catch (\Exception $e) {
            report($e);
            \DB::rollback();
            return ApiFormatter::Blueprint($e->getCode() == 0 ? 500 : ($e->getCode() != 23000 ? $e->getCode() : 500), 'Proses data gagal, silahkan coba lagi');
        }
    }

    public function show(Book $book)
    {
        try {
            $data = $book;
            return ApiFormatter::Blueprint(200, 'Success', $data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \DB::rollback();
            return ApiFormatter::Blueprint(404, 'Data not found');
        } catch (\Exception $e) {
            report($e);
            \DB::rollback();
            return ApiFormatter::Blueprint($e->getCode() == 0 ? 500 : ($e->getCode() != 23000 ? $e->getCode() : 500), 'Proses data gagal, silahkan coba lagi');
        }
    }


    public function update(UpdateRequest $request, Book $book)
    {
        \DB::beginTransaction();
        try {
            $datas = $request->all();
            if ($request->hasFile('image')) {
                // hapus gambar
                $path = storage_path('app/public/image/books/' . $book->image);
                File::delete($path);

                // store data
                $request->image->store('/image/books/');
                $datas['image'] = $request->image->hashName();
            }

            $data = $book->update($datas);
            \DB::commit();
            return ApiFormatter::Blueprint(200, 'Success', $data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \DB::rollback();
            return ApiFormatter::Blueprint(404, 'Data not found');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollback();
            $message = [
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ];
            return ApiFormatter::Blueprint(422, $message);
        } catch (\Exception $e) {
            report($e);
            \DB::rollback();
            return ApiFormatter::Blueprint($e->getCode() == 0 ? 500 : ($e->getCode() != 23000 ? $e->getCode() : 500), 'Proses data gagal, silahkan coba lagi');
        }
    }

    public function destroy(Book $book)
    {
        try {
            // hapus gambar
            $path = storage_path('app/public/image/books/' . $book->image);
            File::delete($path);

            $data = $book->delete();
            return ApiFormatter::Blueprint(200, 'Success', $data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \DB::rollback();
            return ApiFormatter::Blueprint(404, 'Data not found');
        } catch (\Exception $e) {
            report($e);
            \DB::rollback();
            return ApiFormatter::Blueprint($e->getCode() == 0 ? 500 : ($e->getCode() != 23000 ? $e->getCode() : 500), 'Proses data gagal, silahkan coba lagi');
        }
    }
}
