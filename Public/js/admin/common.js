/**
 * Created by intern on 2017/8/22.
 */

//公共js函数

$('#sub_data').click(function () {

});

//点击添加按钮,跳到添加页面
$('#button-add').click(function () {
    var url = SCOPE.add_url;
    window.location.href = url
});

//点击添加数据到后台
$('#cms-button-submit').click(function () {
    //获取前台界面的表单数据:
    //把表单的值序列化,返回数组
    var dataArray = $('#cms-form').serializeArray();
    var data = {};
    $.each(dataArray, function () {
        data[this.name] = this.value;
    });

    //这样下方便后台好取值
    // var arr = {menu:data};
    $.post(SCOPE.save_url, data, function (res) {
        if (res.status === 0) {
            dialog.error(res.message);
        } else if (res.status === 1) {
            dialog.success(res.message, SCOPE.jump_url);
        }

    }, 'JSON');

});

//点击删除事件时,提交跳转到后台
$('.cms-table #cms-delete').each(function () {
    $(this).click(function () {
        var id = $(this).attr('attr-id');
        var status = $(this).attr('attr-status');

        var data = {
            'id': id,
            'status': status
        };

        layer.open({
            title: '提示',
            icon: 2,
            btn: ['yes', 'no'],
            content: '确认删除吗',
            yes: function () {
                toDelete(data);
            }
        });
    });
});

//为删除事件封装一个方法
function toDelete(data) {

    $.post(SCOPE.delete_url, data, function (res) {

        if (res.status === 1) {
            dialog.success('删除成功', SCOPE.jump_url);
        } else {
            dialog.error('删除失败');
        }
    }, 'JSON');
}

//更新事件,为菜单的编辑写一个事件,当点击时跳入后台
$('.cms-table #cms-edit').click(
    function () {
        var id = $(this).attr('attr-id');

        window.location.href = SCOPE.edit_url + '&id=' + id;
    }
);

//为菜单的更新按钮写一个事件,当点击时进入后台进行处理
$('#button-listorder').click(function () {

    var data = {};

    var dataArray = $("#cms-listorder").serializeArray();

    $.each(dataArray, function () {
        data[this.name] = this.value;
    });

    $.post(SCOPE.listorder_url, data, function (res) {
        if (res.status === 1) {

            dialog.success(res.message, SCOPE.jump_url);

        } else if (res.status === 0) {

            dialog.error(res.message);

        }
    }, 'JSON');
});

$('select[name="catid"]').change(
    function () {
        // alert('haha');
        // var position_id = $(this).val();

        var catid = $(this).val();

        // alert(catid);
        // window.location.href = './admin.php?c=positionContent&a=index&position_id='+position_id;

        $.ajax({
            url: "/admin.php?c=Content&a=showContentByCatId",
            type: 'post',
            data: 'catid=' + catid,
            dataType: "html",
            success: function (data) {

                // $('.cms-table tbody').empty();
                alert(data);
                $('.cms-table tbody').html(data);

            }
        });

    }
);

// $('#cms-push').click(function () {
//     var posioion_id = $("#select-push").val();
//     var checkeds = [];
//     var i = 0;
//     $.each($('input[type="checkbox"]'),function ()
//     {
//         if (this.checked)
//         {
//             checkeds[i] = this.value;
//             // alert(checkeds[i]);
//             i++;
//         }
//     });
//     var data = {
//         position_id : posioion_id,
//         news_ids: checkeds
//     };
//     console.log(data);
//     $.post(SCOPE.push_url,data,function (res) {
//         if (res.status == 1)
//         {
//             dialog.success(res.msg,SCOPE.jump_url);
//         }
//         if (res.status ==0)
//         {
//             dialog.error(res.msg);
//         }
//     },'JSON');
// });

$('#cms-push').click(function () {

    var id = $('#select-push').val();

    alert(id);
    //不能用!加变量判断为真
    if (id == 0) {
        return dialog.error('请选择推荐职位');
    }

    var pushData = {};
    var postData = {};
    //被选中的checkbox,获取其value

    $.each($('input[name="pushcheck"]:checked'), function (i) {
        pushData[i] = $(this).val();
    });

    postData['newsIDs'] = pushData;
    postData['position_id'] = id;

    $.post(SCOPE.push_url, postData, function (res) {

        if (res.status == 1) {
            dialog.success(res.message, SCOPE.jump_url);
        } else {
            dialog.error(res.message);
        }
    }, 'JSON');
});

//获取菜单管理中跳转页面的a标签,对a标签进行操作,使之成为ajax跳转
$('.table-responsive').click(
    function (event) {

        $('.pagination a').attr('class','btn btn-primary');
        // alert(event.target.tagName);

        //使用事件代理,消除ajax返回html界面,返回的界面无法二次进行dom操作(因为js文件在该html片段前已经加载过了)
        if (event.target.tagName === 'A') {

            var id = event.target.getAttribute('value');

            // id = parseInt(id);
            if (event.target.text == '上一页') {
                id -= 1;
            }

            if (event.target.text == '下一页') {
                id += 1;
            }


            //ajax提交数据
            var data = {
                'p': id
            };

            $.ajax(
                {
                    url: '/admin.php?m=Admin&c=Menu&a=index',
                    type: 'post',
                    data: data,
                    dataType: 'html',
                    success: function (data) {
                        $('.table-responsive').html(data);
                    }
                }
            );

        }
    }
);

//获取a标签,使用ajax跳转

// $('.collapse .nav li').click(function () {
//
//     //获取子节点
//     var a = $(this).children();
//
//     //获取url
//     var url = a.attr('href');
//
//     //清除默认链接
//     a.attr('href','javascript:void(0);');
//
//     console.log(url);
//     // console.log(val);
//
//
//     //利用异步传输
//
//     $.ajax({
//         url : url,
//         type : 'post',
//         dataType : 'html',
//         success : function (data) {
//
//             $('html').html(data);
//         }
//     })
//
//
//
//
//
// });
