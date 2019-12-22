/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//
// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */
//
// // const files = require.context('./', true, /\.vue$/i)
// // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
//
// // Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//
// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
//
// const app = new Vue({
//     el: '#app',
// });

let selectedId = null;
let dataType = null;

window.setSelectedIdAndType = function setSelectedIdAndType(id, type) {
    selectedId = id;
    dataType = type;
};

$( ".delete-confirm" ).click(function() {
    console.log(selectedId);
    console.log(dataType);
    const id = selectedId;
    const token = $(this).data("token");
    let url = '';
    let locationBack = '';

    if(dataType === 'employee') {
        url = "/employee/delete/" + id;
        locationBack = "/";
    } else {
        url = "/employee-work-hours/delete/" + id;
        locationBack = "/view/" + $(this).data("employee");
    }

    $.ajax(
        {
            url: url,
            type: 'DELETE',
            dataType: "JSON",
            data: {
                "id": id,
                "_method": 'DELETE',
                "_token": token,
            },
            success: function ()
            {
                console.log("Deleted properly");
                window.location = locationBack;
            }
        });

    if(dataType === 'employee') {
        $('#deleteEmployeeModal').modal('hide');
    } else {
        $('#deleteWorkHourModal').modal('hide');
    }
});
