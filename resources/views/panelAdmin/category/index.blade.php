@extends('panelAdmin.layouts.panel')

@section('title','مدیریت دسته بندی ها')


@section('style')
    <style>

        .category-container{
            direction:rtl;
        }


        .page-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
            flex-wrap:wrap;
            gap:15px;
        }


        .page-title h1{
            margin:0;
            font-size:24px;
            font-weight:800;
        }


        .btn{
            border:none;
            padding:10px 18px;
            border-radius:10px;
            text-decoration:none;
            cursor:pointer;
            font-weight:700;
        }


        .btn-primary{
            background:#2563eb;
            color:#fff;
        }


        .card{
            background:#fff;
            border-radius:16px;
            box-shadow:0 5px 25px rgba(0,0,0,.06);
            overflow:hidden;
        }


        .table-responsive{
            overflow-x:auto;
        }


        table{
            width:100%;
            min-width:950px;
            border-collapse:collapse;
        }


        thead{
            background:#f8fafc;
        }


        th{
            padding:15px;
            text-align:right;
            font-size:14px;
        }


        td{
            padding:15px;
            border-top:1px solid #eee;
        }


        .status{
            padding:5px 12px;
            border-radius:20px;
            font-size:12px;
        }


        .active{
            background:#dcfce7;
            color:#166534;
        }


        .disabled{
            background:#fee2e2;
            color:#991b1b;
        }


        .actions{
            display:flex;
            gap:8px;
        }


        .action{
            width:35px;
            height:35px;
            border-radius:8px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:none;
            cursor:pointer;
        }


        .edit{
            background:#fef3c7;
        }


        .delete{
            background:#fee2e2;
        }


        .image-thumb{
            width:45px;
            height:45px;
            object-fit:cover;
            border-radius:10px;
        }


        @media(max-width:768px){

            .page-header{
                flex-direction:column;
                align-items:stretch;
            }

            .btn{
                text-align:center;
            }

        }

    </style>
@endsection



@section('content')


    <div class="category-container">


        <div class="page-header">


            <div class="page-title">

                <h1>
                    مدیریت دسته بندی محصولات
                </h1>

            </div>



            <a href="{{route('admin.category.create')}}"
               class="btn btn-primary">

                + افزودن دسته

            </a>


        </div>




        @if(session('success'))

            <div class="alert alert-success">

                {{session('success')}}

            </div>

        @endif




        <div class="card">


            <div class="table-responsive">


                <table>


                    <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            تصویر
                        </th>


                        <th>
                            کد
                        </th>


                        <th>
                            گروه محصول
                        </th>


                        <th>
                            والد
                        </th>


                        <th>
                            وضعیت
                        </th>


                        <th>
                            ویژه
                        </th>


                        <th>
                            ترتیب
                        </th>


                        <th>
                            عملیات
                        </th>


                    </tr>

                    </thead>



                    <tbody>


                    @forelse($categories as $category)


                        <tr>


                            <td>
                                {{$loop->iteration}}
                            </td>



                            <td>

                                @if($category->image)

                                    <img
                                        src="{{asset('storage/'.$category->image)}}"
                                        class="image-thumb">

                                @else

                                    -

                                @endif

                            </td>




                            <td>
                                {{$category->code}}
                            </td>



                            <td>

                                {{ $category->fa?->name ?? '-' }}

                            </td>




                            <td>
                                {{ $category->parent?->fa?->name ?? 'دسته اصلی' }}
                            </td>




                            <td>


                                @if($category->status)

                                    <span class="status active">
فعال
</span>

                                @else

                                    <span class="status disabled">
غیرفعال
</span>

                                @endif


                            </td>




                            <td>

                                {{$category->is_featured?'بله':'خیر'}}

                            </td>



                            <td>

                                {{$category->sort_order}}

                            </td>



                            <td>


                                <div class="actions">


                                    <a
                                        href="{{route(
'admin.category.edit',
$category
)}}"
                                        class="action edit">

                                        ✏️

                                    </a>



                                    <form
                                        action="{{route(
'admin.category.delete',
$category
)}}"
                                        method="POST">


                                        @csrf

                                        @method('DELETE')


                                        <button
                                            class="action delete"
                                            onclick="return confirm('حذف شود؟')">

                                            🗑

                                        </button>


                                    </form>
                                    <a
                                        href="{{ route('admin.category.translation.index', $category->id) }}"
                                        title="مدیریت ترجمه‌ها"
                                        class="pg-action"
                                        style="color:#7c3aed;"
                                    >
                                        <svg
                                            width="17"
                                            height="17"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 5h12M9 3v2m4 0a8 8 0 01-8 8m0 0H3m2 0a8 8 0 008 8M17 13l4 8m-2-4h-4"
                                            />
                                        </svg>
                                    </a>


                                </div>


                            </td>



                        </tr>


                    @empty


                        <tr>

                            <td colspan="9"
                                style="text-align:center;padding:40px">

                                دسته‌ای ثبت نشده است

                            </td>

                        </tr>


                    @endforelse


                    </tbody>


                </table>


            </div>



            <div style="padding:20px">

                {{$categories->links()}}

            </div>



        </div>



    </div>


@endsection
