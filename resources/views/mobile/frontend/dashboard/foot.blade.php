

    <style>
      @import url('https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900');
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
      }
      :root {
        --clr: #262433;
      }
      body {
        display: flex;
        justify-content: center;
        align-items: center;
        background: var(--clr);
        min-height: 100vh;
      }
      .navigation {
        width: 420px;
        height: 70px;
        background: #fff; /* Change Navigation Color here */
        position: relative;
        display: flex;
        justify-content: center;
        z-index: 1;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
      }
      .navigation ul {
        display: flex;
        width: 350px;
      }
      .navigation ul li {
        position: relative;
        list-style: none;
        width: 70px;
        height: 70px;
        z-index: 1;
      }
      .navigation ul li a {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 100%;
        text-align: center;
        font-weight: 500;
      }
      .navigation ul li a .icon {
        position: relative;
        display: block;
        line-height: 75px;
        font-size: 1.5em;
        text-align: center;
        transition: 0.5s;
        color: #000;
        opacity: 0.75;
      }
      .navigation ul li.active a .icon {
        transform: translateY(-8px);
        opacity: 1;
        color: #29fd;
      }

      .indicator {
        position: absolute;
        top: -10px;
        width: 70px;
        height: 70px;
        border-bottom-left-radius: 35px;
        border-bottom-right-radius: 35px;
        border: 6px solid var(--clr);
        background: var(--clr);
        cursor: pointer;
        transition: 0.5s;
      }
      .indicator::before {
        content: '';
        position: absolute;
        top: 4px;
        left: -25.75px;
        width: 20px;
        height: 20px;
        border-top-right-radius: 20px;
        box-shadow: 4px -6px 0 2px var(--clr);
      }

      .indicator::after {
        content: '';
        position: absolute;
        top: 4px;
        right: -25.75px;
        width: 20px;
        height: 20px;
        border-top-left-radius: 20px;
        box-shadow: -4px -6px 0 2px var(--clr);
        z-index: -1;
      }
      .navigation ul li:nth-child(2).active ~ .indicator {
        transform: translateX(calc(70px * 1));
      }
      .navigation ul li:nth-child(3).active ~ .indicator {
        transform: translateX(calc(70px * 2));
      }
      .navigation ul li:nth-child(4).active ~ .indicator {
        transform: translateX(calc(70px * 3));
      }
      .navigation ul li:nth-child(5).active ~ .indicator {
        transform: translateX(calc(70px * 4));
      }
      .indicator span {
        position: absolute;
        bottom: 3px;
        left: -1px;
        width: 60px;
        height: 60px;
        border: 4px solid #29fd;
        background: #fff;
        border-radius: 50%;
        transform-origin: bottom;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        transform: scale(0.85);
      }
    </style>

    <div class="navigation">
      <ul>
        <li class="list active">
          <a href="#">
            <span class="icon">
              <ion-icon name="home-outline"></ion-icon>
            </span>
          </a>
        </li>
        <li class="list">
          <a href="#">
            <span class="icon">
              <ion-icon name="person-outline"></ion-icon>
            </span>
          </a>
        </li>
        <li class="list">
          <a href="#">
            <span class="icon">
              <ion-icon name="chatbubble-outline"></ion-icon>
            </span>
          </a>
        </li>
        <li class="list">
          <a href="#">
            <span class="icon">
              <ion-icon name="camera-outline"></ion-icon>
            </span>
          </a>
        </li>
        <li class="list">
          <a href="#">
            <span class="icon">
              <ion-icon name="settings-outline"></ion-icon>
            </span>
          </a>
        </li>
        <div class="indicator"><span></span></div>
      </ul>
    </div>
    <!-- partial -->
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="./script.js"></script>
    <script>
      const list = document.querySelectorAll('.list');
      function activelink() {
        list.forEach((item) => item.classList.remove('active'));
        this.classList.add('active');
      }
      list.forEach((item) => item.addEventListener('click', activelink));
    </script>
