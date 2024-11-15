<?php
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy(); 
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stunning Software Development Company</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    
    * { 
      margin: 0; 
      padding: 0; 
      box-sizing: border-box; 
      font-family: 'Roboto', sans-serif; 
    }
    body { 
      color: #333; 
      background-color: #f5f7fa; 
      font-size: 16px; 
      line-height: 1.6; 
    }
    a { 
      text-decoration: none; 
      color: inherit; 
    }

    .container { 
      width: 85%; 
      max-width: 1200px; 
      margin: 0 auto; 
    }
    section { 
      padding: 60px 0; 
    }

    .btn-primary {
      padding: 12px 25px; 
      color: #fff; 
      background-color: #ff5c8d; 
      border-radius: 50px; 
      text-decoration: none; 
      font-weight: 600; 
      transition: all 0.3s ease;
    }
    .btn-primary:hover { 
      background-color: #ff3385; 
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); 
    }

    h2 { font-size: 2.8em; color: #333; margin-bottom: 30px; font-weight: 700; text-align: center; }
    h3 { font-size: 1.6em; margin-bottom: 15px; color: #333; font-weight: 600; }

    
    nav {
      display: flex; justify-content: space-between; align-items: center; background-color: #2d3a3b; color: #fff; padding: 15px 20px; position: sticky; top: 0; width: 100%; z-index: 100; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .logo { font-size: 1.8em; font-weight: 700; color: #fff; }
    .nav-links { display: flex; gap: 20px; }
    .nav-links a { font-size: 1.1em; font-weight: 500; color: #fff; transition: color 0.3s ease; }
    .nav-links a:hover { color: #f1f1f1; text-decoration: underline; }

    #home {
      height: 100vh; background: linear-gradient(to right, #2d3a3b, #ff5c8d); color: #fff; display: flex; justify-content: center; align-items: center; text-align: center;
    }
    #home h1 { font-size: 3.5em; margin-bottom: 20px; font-weight: 700; letter-spacing: 1px; }
    #home p { font-size: 1.2em; max-width: 700px; line-height: 1.6; margin-bottom: 20px; font-weight: 400; }

    #about { background-color: #fff; box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 40px; display: flex; gap: 40px; align-items: center; }
    #about img { max-width: 400px; border-radius: 10px; }
    #about .text { max-width: 650px; }
    #about h2 { font-size: 2.4em; margin-bottom: 20px; color: #2d3a3b; font-weight: 600; }

    #services { background-color: #f5f7fa; }
    .service-card {
      background-color: #fff; box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.1); border-radius: 10px;
      padding: 30px; text-align: center; flex: 1;
    }
    .service-card h3 { font-size: 2em; margin-bottom: 15px; color: #2d3a3b; font-weight: 600; }
    .service-card p { font-size: 1.1em; color: #666; }

    #portfolio { background-color: #fff; }
    .portfolio-item {
      display: inline-block; width: 30%; margin: 1.5%; background-color: #f0f0f0; border-radius: 10px; overflow: hidden; transition: transform 0.3s ease;
    }
    .portfolio-item:hover { transform: scale(1.05); }
    .portfolio-item img { width: 100%; }
    .portfolio-item h4 { padding: 15px; font-size: 1.4em; background-color: #2d3a3b; color: #fff; }

    #testimonials { background-color: #f5f7fa; text-align: center; }
    .testimonial-card {
      background-color: #fff; box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.1); border-radius: 8px;
      padding: 40px; margin: 20px; max-width: 600px; display: inline-block;
    }
    .testimonial-card p { font-size: 1.1em; color: #666; margin-bottom: 20px; }
    .testimonial-card h4 { font-size: 1.4em; color: #2d3a3b; font-weight: 600; }

    #contact { background-color: #fff; padding: 40px; box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.1); border-radius: 8px; }
    .contact-form { display: flex; flex-direction: column; gap: 15px; }
    .contact-form input, .contact-form textarea {
      padding: 12px; font-size: 1em; border: 1px solid #ddd; border-radius: 5px;
    }
    .contact-form button {
      padding: 12px 25px; background-color: #ff5c8d; color: white; border: none; border-radius: 5px;
      font-size: 1.1em; cursor: pointer; transition: all 0.3s ease;
    }
    .contact-form button:hover { background-color: #ff3385; }

    footer { padding: 20px 0; background-color: #2d3a3b; color: #fff; text-align: center; font-size: 1em; }
    footer a { color: #fff; font-weight: 600; margin-left: 10px; }

    @media (max-width: 768px) {
      .nav-links { flex-direction: column; align-items: center; gap: 15px; }
      #home h1 { font-size: 2.5em; }
      #home p { font-size: 1.1em; }
      #about { flex-direction: column; text-align: center; }
      #about img { max-width: 100%; }
      .service-card, .testimonial-card { width: 100%; }
      .portfolio-item { width: 100%; }
    }
  </style>
</head>
<body>
  <nav>
    <div class="container">
      <h3 class="logo">DevMatrix Co.</h3>
      <div class="nav-links">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#services">Services</a>
        <a href="#portfolio">Portfolio</a>
        <a href="#testimonials">Testimonials</a>
        <a href="#contact">Contact</a>
      </div>
    </div>
  </nav>
  <section id="home">
    <div>
      <h1>Building Tomorrow's Technology Today</h1>
      <p>Your partner in crafting innovative, scalable, and powerful software solutions for businesses of all sizes.</p>
      <a href="#contact" class="btn-primary">Get in Touch</a>
    </div>
  </section>

  <section id="about">
    <div>
      <img src="https://via.placeholder.com/400" alt="About Us">
      <div class="text">
        <h2>About Us</h2>
        <p>At DevMatrix Co., we specialize in delivering custom software solutions tailored to meet the needs of businesses across the globe. We harness the latest technologies to create robust, scalable applications.</p>
      </div>
    </div>
  </section>

  <section id="services">
    <div class="container">
      <h2>Our Services</h2>
      <div style="display: flex; gap: 30px; flex-wrap: wrap; justify-content: center;">
        <div class="service-card">
          <h3>Web Development</h3>
          <p>We build responsive, user-friendly websites tailored to your needs.</p>
        </div>
        <div class="service-card">
          <h3>Mobile App Development</h3>
          <p>We develop native and cross-platform mobile applications for both iOS and Android.</p>
        </div>
        <div class="service-card">
          <h3>Software Engineering</h3>
          <p>Custom software solutions to streamline and automate your business processes.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="portfolio">
    <div class="container">
      <h2>Our Portfolio</h2>
      <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        <div class="portfolio-item">
          <img src="https://via.placeholder.com/600x400" alt="Project 1">
          <h4>Project 1</h4>
        </div>
        <div class="portfolio-item">
          <img src="https://via.placeholder.com/600x400" alt="Project 2">
          <h4>Project 2</h4>
        </div>
        <div class="portfolio-item">
          <img src="https://via.placeholder.com/600x400" alt="Project 3">
          <h4>Project 3</h4>
        </div>
      </div>
    </div>
  </section>

  <section id="testimonials">
    <div class="container">
      <h2>What Our Clients Say</h2>
      <div style="display: flex; gap: 30px; justify-content: center; flex-wrap: wrap;">
        <div class="testimonial-card">
          <p>"DevMatrix Co. helped us develop our mobile app and the process was smooth and efficient. Highly recommended!"</p>
          <h4>John Doe, CEO</h4>
        </div>
        <div class="testimonial-card">
          <p>"Their team is knowledgeable, professional, and delivers great results. We couldn't be happier with the software they created."</p>
          <h4>Jane Smith, CTO</h4>
        </div>
      </div>
    </div>
  </section>

  <section id="contact">
    <div class="container">
      <h2>Contact Us</h2>
      <form class="contact-form">
        <input type="text" placeholder="Your Name" required>
        <input type="email" placeholder="Your Email" required>
        <textarea placeholder="Your Message" rows="6" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>
  </section>

  <footer>
    <p>&copy; 2024 DevMatrix Co. All Rights Reserved. <a href="#contact">Contact Us</a></p>
  </footer>
</body>
</html>
