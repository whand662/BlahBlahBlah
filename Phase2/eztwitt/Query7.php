<!DOCTYPE html>
<html>
      <head>
          <meta charset="UTF-8">
            <style>
              body{
                  background: url(background2.jpg);
                  background-size: cover;
                  margin: 0;
              }
              input{
                  width: 70%;
                  outline: none;
                  padding: 10px 11px;
                  border: 1px #aaa solid;
                  font-size: 15px;
                  background: #fff;
                  display: block;
                  margin: 20px auto;
              }
              #login{
                  background:a2b9bc;
                  color: #fff;
                  border: none;
              }
              div{
                  width: 30%;
                  height: 400px;
                  background: rgba(0,0,0,.2);
                  box-shadow: 5px 4px 43px #000;
                  position: absolute;
                  top: 80px;
                  left: 200px;
              }
              form{
                  margin: 30px auto;
                  text-align: center;
              }
              b{
                  font-size: 30px;
                  color: ##3e4444;
              }
              a{
                  color: ##fff;
              }
              img{
                  display: block;
                  margin: -60px auto 0 auto;
                  border: none;
                  box-shadow: 5px 4px 43px #000;
              }
          </style>
      </head>

      <body>
        <div>
          <form action="process.php" method="POST" style="text-align:center;">
            <img src="logoUser.png"  />
            <b>Login</b>
            <input type="text" placeholder="Username" id="username" name="username"  />
            <input type="password" placeholder="Password" id="password" name="password"  />
            <input type="submit" value="Login" name="submit">
          </form>
        </div>
      </body>
</html>
