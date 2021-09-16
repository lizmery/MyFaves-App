let details = document.querySelectorAll('#details');
let id;

details.forEach((item) => {
    item.addEventListener('click', () => {
        id = $(item).attr('data-id');

        $.ajax({url:"details.php?id=" + id, cache:false, success:function(result) {
            $('.modal-content').html(result);
        }});
    });
});

function showInput(e) {
    if(e.value == "new") {
        document.getElementById('new-input').style.display = "block";
    } else {
        document.getElementById('new-input').style.display = "none";
    }
};




