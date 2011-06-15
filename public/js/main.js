$(document).ready(function() {
  $("#commentForm").validate({
    rules: {
      username: "required",    // simple rule, converted to {required: true}
      email: {             // compound rule
      required: true,
      email: true
      },
      url: {
        url: true
      },
      comment: {
        required: true
      }
    },
    messages: {
      comment: "Please enter a comment."
    }
  });
});
