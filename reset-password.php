<?php
  require "frontpage.html";
?>

   <main>
     <div class="wrapper-main">
       
         <h1>Reset your password</h1>
         <p> An e-mail will be sent to you with instructions on how to reset your password.</p>
          <form class="wrapper-main" action="includes/reset-request.inc.php" method="post">
            <input type="text" name="email" placeholder="Enter your e-mail address....">
            <button type="submit" name="reset-request-submit">Recieve new password by email</button>

          </form>
         
            
       </section>
     </div>
   </main>