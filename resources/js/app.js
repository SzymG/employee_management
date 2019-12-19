require('./bootstrap');
require('./jquery.min');

let selectedId = null;
let dataType = null;

window.setSelectedIdAndType = function setSelectedIdAndType(id, type) {
    selectedId = id;
    dataType = type;
};

$( ".delete-confirm" ).click(function() {
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

