<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.27.3/dist/apexcharts.min.js"></script>
    <script src="scripts/dark.js"></script>
    <script src="scripts/nav.js"></script>
  </head>
  <body>
    <header>
      <a href="#" class="logo">TRIAGE</a>
      <form>
        <input type="text" placeholder="Search..." />
        <input type="submit" value="Go" />
      </form>
      <div class="user-profile">
        <span class="username">John Doe</span>
        <!-- <a href="#" class="logout-link">Log out</a> -->

        <label class="switch">
          <input
            type="checkbox"
            id="dark-mode-toggle"
            onclick="toggleDarkMode()"
          />
          <span class="emoji">🌙</span>
        </label>
      </div>
    </header>
  </body>
</html>
