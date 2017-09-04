/**
 * Created by intern on 2017/8/21.
 */


var dialog = {
    error : function (message) {

        layer.open({
            icon : 2,
            title : '失败',
            content : message
        });
    },

    success : function (message,url) {

        layer.open({
            icon : 1,
            title : '成功',
            content : message,
            yes : function () {
                window.location.href = url
            }
        })
    }
};