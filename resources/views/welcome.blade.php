<nav class="top-nav">
    <div class="nav-container">
        <div class="brand-name">SHARAFAT SHAMS</div>
        <a href="{{ route('login') }}" class="btn-login">Login</a>
    </div>
</nav>

<div class="welcome-wrapper">
    <div class="content-box">
        <img src="{{ asset('assets/img/icons/spot-illustrations/d.png') }}" 
             class="top-image" 
             alt="Welcome Image">
        <h1 class="welcome-text">COMFORT - ELEGANCE - LUXURY</h1>
    </div>
</div>

<style>
/* 1. Reset & Navigation Bar */
.top-nav {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 60px;
    background-color: #fff;
    border-bottom: 1px solid #eee;
    z-index: 1000;
    display: flex;
    align-items: center;
}

.nav-container {
    width: 100%;
    padding: 0 40px;
    display: flex;
    justify-content: space-between; /* This pushes name left and button right */
    align-items: center;
}

.brand-name {
    font-size: 18px;
    font-weight: 700;
    letter-spacing: 1px;
    color: #333;
}

.btn-login {
    background-color: green;
    color: white;
    padding: 8px 25px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
    font-size: 14px;
    transition: 0.3s;
}

.btn-login:hover {
    background-color: #006400;
}

/* 2. Content Centering */
.welcome-wrapper {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 60px; /* Offset for the fixed nav bar */
    text-align: center;
}

.top-image {
    width: 350px; /* Adjusted based on your logo size */
    max-width: 90%;
    height: auto;
    margin-bottom: 30px;
}

.welcome-text {
    font-size: 42px;
    font-weight: 600;
    color: green;
    letter-spacing: 1px;
}
</style>