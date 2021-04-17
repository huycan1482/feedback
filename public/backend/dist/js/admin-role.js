$(document).ready(function () {
    let id;

    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    });

    $('#btnCreate').click(function () {
        let name = $('#createName').val();
        $result = confirm("Bạn có muốn thêm role có Name: " + name);

        if ($result) {
            $.ajax({
                method: "POST",
                url: "http://duchuy.local:8080/admin/role/create",
                data: {
                    name: name
                },

                dataType : 'json',

                success: function (response) {
                    // alert(response);
                    // console.log(response);
                }
            });

            $('#btnCreate').attr('data-dismiss', 'modal');

            location.reload();
        } else {
            alert("Hủy thêm thành công");
        }

    });

    $('.btnDel').click(function () {
        let id_product = $(this).attr('data-id');
        let position = $(this);
        $result = confirm("Bạn có muốn xóa role có mã " + id_product);

        if ($result) {
            $.ajax({
                method: "POST",
                url: "http://duchuy.local:8080/admin/role/destroy",
                data: {
                    id: id_product
                },

                dataType: 'json',
                
                success: function (response) {
                    // let returnData = response;
                    // if ( returnData.status != undefined && returnData.status == 1 ) {
                    //     position.closest('tr').remove();
                    // }
                }
            });

        } else {
            alert('Hủy xóa thành công');
        }
    });

    $('.btnUpdate').click(function () {
        id = $(this).attr('data-id');

        $('.roleId').text('Role ID: ' + $(this).attr('data-id'));
        $('.roleName').attr('placeholder', $(this).attr('data-name'));
    });

    $('#btnUpdate').click(function () {
        let name = $('#updateName').val();

        $result = confirm('Bạn có muốn sửa role có mã ' + id + ' thành ' + name);

        if ($result) {
            $.ajax({
                method: "POST",
                url: "http://localhost:8080/mvc/?controller=role&action=update",
                data: {
                    name: name,
                    id: id
                },

                success: function (response) {
                    console.log(response);
                }
            });

            $('#btnUpdate').attr('data-dismiss', 'modal');

            location.reload();

        } else {
            alert('Hủy cập nhập thành công');
        }
    });

    //  cach 2 su dung json

});