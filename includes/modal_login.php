<link rel="stylesheet" href="public/css/modal_login.css">

<div id="id01" class="modal">
    <header class="w3-display-container w3-content modal-content animate" style="max-width:1000px;"> <!-- Overarching container for background image -->
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        <img class="w3-image" src="./public/images/bg-hotel.jpg" alt="The Hotel" style="min-width:1000px; border: 10px solid black;" width="1000" height="1000">
        <div class="w3-display-middle w3-padding w3-col l6 m8"> <!-- Container for registration form -->
            <div class="w3-container w3-red"> <!-- Title container -->
                <h2><i class="fa fa-bed w3-margin-right"></i>Login</h2>
            </div>
            <div class="w3-container w3-white w3-padding-16"> <!-- Fields container -->
                <!-- Form goes here -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="w3-row-padding">
                        <div class="w3-col s12 m12 l12 w3-margin-bottom">
                            <label for="username">Username:</label>
                            <input class="w3-input w3-border" type="text" id="username" name="username" placeholder="Email" required>
                        </div>
                        <div class="w3-col s12 m12 l12 w3-margin-bottom">
                            <label for="password">Password:</label>
                            <input class="w3-input w3-border" type="password" id="pw" name="pw" placeholder="Enter Password" required>
                        </div>
                        <div class="w3-col s12 m12 l12 w3-margin-bottom">
                            <br>
                            <input class="w3-button w3-block w3-green login" type="submit" value="Login">
                            <span class="psw">Forgot <a href="#">password?</a></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </header>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>