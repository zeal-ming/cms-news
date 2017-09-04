/**
 * Created by intern on 2017/8/21.
 */


var login = {

    check : function () {

        var username = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();
        //
        // alert('haha');
        // alert(username);

        if(!username){
            layer.open('用户名不能为空');
        } else if(!password) {
            layer.open('密码不能为空');
        }


        //ajax提交数据
        var data = {
            'username' : username,
            'password' : password
        };

        var url = './admin.php?c=login&a=check';

        $.post(url,data,function (res) {

            if(res.status === 0){
                // layer.open(res.message);
                dialog.error(res.message);
            } else if(res.status === 1){

                dialog.success(res.message,'./admin.php?c=index&a=index');
            }
        },'JSON');
    }
};