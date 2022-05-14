$(function () {
    'use strict';





    $.ajax({
        url: link + '/popup',
        method: 'get',


        success: function (respo) {

                $('body').append(respo.msg);

        },


    })



})