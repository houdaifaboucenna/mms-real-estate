import './bootstrap';

$('.delete-btn').on('click', function (event) {
  event.preventDefault();
  const form = $(this).parent("form");
  swal({
    title: 'Confirm deleting ?',
    icon: 'warning',
    buttons: ["No", "Yes"],
  }).then(function (value) {
    if (value) {
      form.submit()
    }
  });
});


$(".ad-btn").on('click', function () {
  var html = $(".clone").html();
  $(".increment").after(html);
});

$("body").on('click', ".rm-btn", function () {
  $(this).parents(".control-group").remove();
});
