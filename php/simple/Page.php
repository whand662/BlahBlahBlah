

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
      <img src="logoUser.png"  class="center">
      <h1 align="center">Welcome to EzTwitt</h1>

    <style>
      body{
          background: url(background2.jpg);
          background-size: cover;
          margin: 0;
      }
      .center {
          display: block;
          margin-left: auto;
          margin-right: auto;
          width: 10%;
       }

      </style>



  </head>
  <body>
    <h2>Querries</h2>
    <p>Find all the posts made by all the users in descended order.</p>
    <div>
      <form action="Query.php" method="POST">
        <input type="submit" name="submit">
      </form>
    </div>
  </body>
    <body>
      <p>1. Find the post that has the most number of likes.</p>
      <div>
        <form action="Query1.php" method="POST">
          <input type="submit" name="submit">
        </form>
        </div>
    </body>
    <body>
      <p>2. Find the person who has the most number of followers.</p>
      <div>
        <form action="Query2.php" method="POST">
          <input type="submit" name="submit">
        </form>
        </div>
    </body>
    <body>
      <p>3. Count the number of posts that contains the keyword “flu”, display the location of the users who have made the posts as well (use “GROUP BY location”).</p>
      <div>
        <form action="Query3.php" method="POST">
          <input type="submit" name="submit">
          </form>
        </div>
    </body>
    <body>
      <p>4. User input a person’s twitter name, find all the posts made by that person.</p>
      <div>
        <form action="Query4.php" method="POST">
          Enter user name: <input type="text" placeholder="User name" id="username" name="username"  />
              <br></br>
              <input type="submit" name="submit">
        </form>
        </div>
    </body>
    <body>
      <p>5. User input a year, find the person who twits the most in that year.</p>
      <div>
        <form action="Query5.php" method="POST">
          Enter a year: <input type="text" placeholder="Year" id="post_time" name="year"  />
              <br></br>
          <input type="submit" name="submit">
        </form>
        </div>
    </body>
    <body>
      <p>6. After log in, find all the senders of messages to the user.</p>
      <div>
        <form action="Query6.php" method="POST">
          <input type="submit" name="submit">
        </form>
        </div>
    </body>
    <body>
      <p>7. After log in, user posts a new twit.</p>
      <div>
        <form action="Query7.php" method="POST">
          <input type="submit" name="submit">
        </form>
        </div>
    </body>
    <body>
      <p>8. After log in, user follows/unfollows another user.</p>
      <div>
        <form action="Query8.php" method="POST">
          <input type="submit" name="submit">
        </form>
        </div>
    </body>
    <body>
      <p>9. After log in, user adds comment to a post.</p>
      <div>
        <form action="Query9.php" method="POST">
          <input type="submit" name="submit">
        </form>
        </div>
    </body>
      <p>10. After log in, user deletes a particular comment to a post he/she has created.</p>
      <div>
        <form action="Query10.php" method="POST">
          <input type="submit" name="submit">
        </form>
      </div>
  </body>

</html>
