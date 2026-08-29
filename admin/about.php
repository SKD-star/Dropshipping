<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Lady London</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
    /* Reset and base styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        line-height: 1.6;
        color: #333;
        font-family: 'Montserrat', sans-serif;
        font-size: 16px;
        overflow-x: hidden;
        background-color: #fcfcfc;
    }

    a {
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
    }


/* Hero section */
.hero {
    background-image: linear-gradient(rgba(34, 10, 41, 0.8), rgba(34, 10, 41, 0.8)), url('/images/fashion-background.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    position: relative;
    margin-bottom: 60px;
}

.hero-content {
    max-width: 800px;
    padding: 0 20px;
}

.hero-content h1 {
    font-family: 'Playfair Display', serif;
    font-size: 46px;
    margin-bottom: 20px;
    font-weight: 700;
    line-height: 1.2;
    position: relative;
    padding-bottom: 20px;
}

.hero-content h1:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: #d4af37;
}

/* About section styling */
.about-section {
    padding: 80px 0;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-subtitle {
    color: #d4af37;
    font-size: 16px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 10px;
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 42px;
    color: #220a29;
    position: relative;
    padding-bottom: 20px;
    margin-bottom: 20px;
}

.section-title:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: #d4af37;
}

.section-description {
    max-width: 600px;
    margin: 0 auto;
    font-size: 17px;
    color: #555;
    line-height: 1.8;
}

/* Story section */
.story-section {
    padding: 0 0 80px;
}

.story-container {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
}

.story-image {
    flex: 1;
    min-width: 300px;
    padding: 0 15px;
    margin-bottom: 30px;
}

.story-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.story-content {
    flex: 1;
    min-width: 300px;
    padding: 0 15px;
}

.story-content h3 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #220a29;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 15px;
}

.story-content h3:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background-color: #d4af37;
}

.story-text {
    font-size: 16px;
    line-height: 1.8;
    color: #444;
    margin-bottom: 25px;
}

.story-text p {
    margin-bottom: 20px;
}

/* Timeline section */
.timeline-section {
    background-color: #f8f9fa;
    padding: 80px 0;
}

.timeline {
    position: relative;
    max-width: 1000px;
    margin: 50px auto 0;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 100%;
    background-color: #d4af37;
}

.timeline-item {
    display: flex;
    justify-content: flex-end;
    padding-right: 30px;
    position: relative;
    margin-bottom: 60px;
    width: 50%;
}

.timeline-item:nth-child(even) {
    align-self: flex-end;
    justify-content: flex-start;
    padding-left: 30px;
    padding-right: 0;
    margin-left: 50%;
}

.timeline-item:before {
    content: '';
    position: absolute;
    top: 20px;
    right: -9px;
    width: 20px;
    height: 20px;
    background-color: #d4af37;
    border-radius: 50%;
    box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.2);
    z-index: 1;
}

.timeline-item:nth-child(even):before {
    right: auto;
    left: -11px;
}

.timeline-content {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.05);
    position: relative;
    width: 100%;
}

.timeline-year {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    font-weight: 700;
    color: #220a29;
    margin-bottom: 10px;
    display: inline-block;
    padding: 5px 15px;
    background-color: rgba(34, 10, 41, 0.1);
    border-radius: 20px;
}

.timeline-title {
    font-size: 20px;
    margin-bottom: 15px;
    color: #333;
    font-weight: 600;
}

.timeline-text {
    font-size: 15px;
    line-height: 1.7;
    color: #555;
}

/* Core values section */
.values-section {
    padding: 80px 0;
}

.values-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-top: 40px;
}

.value-card {
    flex: 0 0 calc(33.333% - 30px);
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.08);
    padding: 40px 30px;
    margin-bottom: 30px;
    text-align: center;
    transition: all 0.3s ease;
}

.value-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.value-icon {
    width: 80px;
    height: 80px;
    line-height: 80px;
    text-align: center;
    background-color: rgba(34, 10, 41, 0.1);
    border-radius: 50%;
    margin: 0 auto 25px;
    font-size: 30px;
    color: #220a29;
}

.value-title {
    font-size: 22px;
    font-weight: 600;
    color: #220a29;
    margin-bottom: 15px;
}

.value-text {
    font-size: 15px;
    color: #555;
    line-height: 1.7;
}

/* Quote section */
.quote-section {
    background-color: #220a29;
    color: white;
    padding: 80px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.quote-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: linear-gradient(rgba(34, 10, 41, 0.9), rgba(34, 10, 41, 0.9)), url('/images/pattern.png');
    background-size: cover;
    opacity: 0.1;
}

.quote-content {
    position: relative;
    z-index: 1;
    max-width: 800px;
    margin: 0 auto;
}

.quote-text {
    font-family: 'Playfair Display', serif;
    font-size: 36px;
    line-height: 1.4;
    position: relative;
    padding: 0 50px;
}

.quote-mark {
    font-family: 'Georgia', serif;
    font-size: 120px;
    position: absolute;
    opacity: 0.3;
    color: #d4af37;
    line-height: 0;
}

.quote-mark.left {
    top: 30px;
    left: 0;
}

.quote-mark.right {
    bottom: -20px;
    right: 0;
}

/* Awards section */
.awards-section {
    padding: 80px 0;
    background-color: #f8f9fa;
}

.awards-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 40px;
}

.award-card {
    flex: 0 0 calc(33.333% - 30px);
    max-width: 350px;
    margin: 0 15px 30px;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.award-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.award-image {
    height: 200px;
    overflow: hidden;
}

.award-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.award-card:hover .award-image img {
    transform: scale(1.1);
}

.award-content {
    padding: 25px;
}

.award-title {
    font-size: 20px;
    font-weight: 600;
    color: #220a29;
    margin-bottom: 10px;
}

.award-year {
    font-size: 14px;
    color: #d4af37;
    margin-bottom: 15px;
    display: block;
}

.award-description {
    font-size: 15px;
    color: #555;
    line-height: 1.7;
}

/* CTA section */
.cta-section {
    padding: 80px 0;
    background-image: linear-gradient(rgba(34, 10, 41, 0.9), rgba(34, 10, 41, 0.9)), url('/images/fashion-bg.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    color: white;
    text-align: center;
}

.cta-content {
    max-width: 700px;
    margin: 0 auto;
}

.cta-title {
    font-family: 'Playfair Display', serif;
    font-size: 36px;
    margin-bottom: 20px;
}

.cta-text {
    font-size: 18px;
    margin-bottom: 30px;
    line-height: 1.7;
}

.cta-button {
    display: inline-block;
    background-color: #d4af37;
    color: white;
    padding: 15px 35px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
}

.cta-button:hover {
    background-color: white;
    color: #d4af37;
    transform: translateY(-3px);
}

/* Footer */
footer {
    background-color: #220a29;
    color: white;
    padding: 70px 0 0;
}

.footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-bottom: 50px;
}

.footer-column {
    flex: 1;
    min-width: 250px;
    margin-bottom: 30px;
    padding: 0 15px;
}

.footer-logo {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.footer-logo img {
    height: 40px;
    margin-right: 10px;
}

.footer-logo-text {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    font-weight: 700;
    color: white;
}

.footer-about {
    font-size: 14px;
    line-height: 1.8;
    margin-bottom: 20px;
    color: rgba(255, 255, 255, 0.7);
}

.footer-social {
    display: flex;
    list-style: none;
}

.footer-social li {
    margin-right: 15px;
}

.footer-social a {
    display: block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: white;
    font-size: 18px;
    transition: all 0.3s ease;
}

.footer-social a:hover {
    background-color: #d4af37;
    transform: translateY(-3px);
}

.footer-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 10px;
}

.footer-title:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background-color: #d4af37;
}

.footer-links {
    list-style: none;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
    transition: all 0.3s ease;
}

.footer-links a:hover {
    color: #d4af37;
    padding-left: 5px;
}

.footer-contact {
    list-style: none;
}

.footer-contact li {
    margin-bottom: 15px;
    display: flex;
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
}

.footer-contact i {
    margin-right: 12px;
    color: #d4af37;
    font-size: 18px;
    min-width: 20px;
}

.footer-newsletter p {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 20px;
    line-height: 1.8;
}

.newsletter-form {
    position: relative;
}

.newsletter-input {
    width: 100%;
    padding: 12px 15px;
    background-color: rgba(255, 255, 255, 0.1);
    border: none;
    border-radius: 30px;
    color: white;
    font-size: 14px;
    outline: none;
}

.newsletter-button {
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
    padding: 0 20px;
    background-color: #d4af37;
    border: none;
    border-radius: 0 30px 30px 0;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.newsletter-button:hover {
    background-color: #c19c2e;
}

.footer-bottom {
    padding: 20px 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    text-align: center;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.6);
}

/* Responsive styles */
@media screen and (max-width: 1024px) {
    .value-card {
        flex: 0 0 calc(50% - 20px);
    }
    
    .award-card {
        flex: 0 0 calc(50% - 30px);
    }
}

@media screen and (max-width: 768px) {
    .mobile-menu-btn {
        display: block;
    }
    
    .nav-links {
        position: fixed;
        top: 84px;
        left: 0;
        width: 100%;
        height: 0;
        background-color: white;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        overflow: hidden;
        transition: all 0.5s ease;
        box-shadow: 0 10px 15px rgba(0,0,0,0.1);
    }
    
    .nav-links.active {
        height: auto;
        padding: 20px 0;
    }
    
    .nav-links li {
        margin: 15px 0;
    }
    
    .story-image, .story-content {
        flex: 0 0 100%;
    }
    
    .timeline:before {
        left: 40px;
    }
    
    .timeline-item {
        width: 100%;
        padding-left: 70px;
        padding-right: 0;
    }
    
    .timeline-item:nth-child(even) {
        margin-left: 0;
        padding-left: 70px;
    }
    
    .timeline-item:before, .timeline-item:nth-child(even):before {
        left: 30px;
        right: auto;
    }
    
    .value-card {
        flex: 0 0 100%;
    }
    
    .award-card {
        flex: 0 0 100%;
        max-width: 400px;
    }
    
    .hero-content h1 {
        font-size: 36px;
    }
}

@media screen and (max-width: 480px) {
    .top-bar a {
        font-size: 12px;
        margin-left: 10px;
    }
    
    .logo-text {
        font-size: 24px;
    }
    
    .section-title {
        font-size: 32px;
    }
    
    .quote-text {
        font-size: 28px;
        padding: 0 30px;
    }
    
    .quote-mark.left {
        font-size: 80px;
        top: 20px;
    }
    
    .quote-mark.right {
        font-size: 80px;
    }
    
    .cta-title {
        font-size: 30px;
    }
    
    .cta-text {
        font-size: 16px;
    }
}
</style>
</head>
<body>
<?php
    include 'header.php';
?>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php">
                        <img src="images/logo.png" alt="<?php echo $companyName; ?> Logo">
                    </a>
                </div>
                
                <div class="mobile-menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </div>
                
                <nav class="nav" id="navLinks">
                    <div class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                    </div>
                    <div class="nav-item">
                        <a href="about.php" class="nav-link active">About Us</a>
                    </div>
                    <div class="nav-item">
                        <a href="products.php" class="nav-link">Products</a>
                    </div>
                    <div class="nav-item">
                        <a href="contact.php" class="nav-link">Contact Us</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Legacy Of 30 Years, 15 Years Of Industry Expertise</h1>
        </div>
    </section>
    
    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">Our Story</p>
                <h2 class="section-title">About Lady London</h2>
                <p class="section-description">Discover the journey behind London's premier fashion export company built on passion, expertise, and dedication to quality.</p>
            </div>
        </div>
    </section>
    
    <!-- Story Section -->
    <section class="story-section">
        <div class="container">
            <div class="story-container">
                <div class="story-image">
                    <img src="/images/fashion-studio.jpg" alt="Lady London Fashion Studio">
                </div>
                <div class="story-content">
                    <h3>Our Journey</h3>
                    <div class="story-text">
                        <p>The foundation of this 30 years legacy was laid by Lady London's founder when she started as the sole agent of premium British fashion in London's famous fashion district. After a brilliant run of 15 years, her daughters Jane and Elizabeth, a fashion designer and business manager respectively, took over the business and thus started their entrepreneurial journey.</p>
                        
                        <p>Sensing potential for growth in the fashion export sector, Jane established 'London Style Enterprises' in 2005 to cater to the domestic British market with the aim to be the leading wholesaler of export surplus readymade garments. Later on, addressing the growing need for British fashion overseas, the sisters established 'Lady London' in 2010.</p>
                        
                        <p>With 15 years in the industry, London-based Lady London is now considered to be one of the most reputed and leading exporters and distributors of 100% genuine export surplus garments for men, women and children. The company has grown over time to acquire in-depth market knowledge and expertise.</p>
                    </div>
                </div>
            </div>
            
            <div class="story-container" style="margin-top: 50px;">
                <div class="story-content">
                    <h3>Expanding Our Vision</h3>
                    <div class="story-text">
                        <p>Over the years, the business scaled and achieved great heights under the vision of Jane as she expanded the export portfolio to include an extensive range of products other than garments. Lady London has now become a turnkey, one-point solution for all sourcing and export-related requirements by international buyers, and has a strong network of working relations worldwide.</p>
                        
                        <p>Elizabeth moved to New York, USA in 2015 and started 'London Boutique' in 2017 – a retail outlet of British & European Fashion garments upon sensing the need and demand for British fashion among local consumers. Together, they also started Global Trade Inc. in 2020 for sourcing products to and from USA as buying and selling agents.</p>
                        
                        <p>A journey that started with London Style Enterprises is now on its way to create a legacy with 'Fashion Global', one of Britain's first e-commerce wholesale sites created in 2022 to make business convenient and faster, and reach a global customer-base.</p>
                    </div>
                </div>
                <div class="story-image">
                    <img src="/images/fashion-global.jpg" alt="Lady London Global Network">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Timeline Section -->
    <section class="timeline-section">
        <div class="container">
        <div class="section-header">
    <p class="section-subtitle">Our Milestones</p>
    <h2 class="section-title">The Lady London Timeline</h2>
    <p class="section-description">Explore our journey from humble beginnings to becoming a leading fashion export company.</p>
</div>

<div class="timeline">
    <div class="timeline-item">
        <div class="timeline-content">
            <span class="timeline-year">1993</span>
            <h3 class="timeline-title">The Foundation</h3>
            <p class="timeline-text">Our founder began as the sole agent of premium British fashion in London's famous fashion district.</p>
        </div>
    </div>
    
    <div class="timeline-item">
        <div class="timeline-content">
            <span class="timeline-year">2005</span>
            <h3 class="timeline-title">London Style Enterprises</h3>
            <p class="timeline-text">Jane established London Style Enterprises to cater to the domestic British market as a leading wholesaler of export surplus readymade garments.</p>
        </div>
    </div>
    
    <div class="timeline-item">
        <div class="timeline-content">
            <span class="timeline-year">2010</span>
            <h3 class="timeline-title">Lady London is Born</h3>
            <p class="timeline-text">The sisters established Lady London to address the growing demand for British fashion overseas.</p>
        </div>
    </div>
    
    <div class="timeline-item">
        <div class="timeline-content">
            <span class="timeline-year">2015</span>
            <h3 class="timeline-title">Expansion to USA</h3>
            <p class="timeline-text">Elizabeth moved to New York to explore opportunities in the American market.</p>
        </div>
    </div>
    
    <div class="timeline-item">
        <div class="timeline-content">
            <span class="timeline-year">2017</span>
            <h3 class="timeline-title">London Boutique</h3>
            <p class="timeline-text">Elizabeth launched London Boutique in New York - a retail outlet specializing in British & European fashion garments.</p>
        </div>
    </div>
    
    <div class="timeline-item">
        <div class="timeline-content">
            <span class="timeline-year">2020</span>
            <h3 class="timeline-title">Global Trade Inc.</h3>
            <p class="timeline-text">The sisters established Global Trade Inc. for sourcing products to and from USA as buying and selling agents.</p>
        </div>
    </div>
    
    <div class="timeline-item">
        <div class="timeline-content">
            <span class="timeline-year">2022</span>
            <h3 class="timeline-title">Fashion Global</h3>
            <p class="timeline-text">Launch of Fashion Global, one of Britain's first e-commerce wholesale sites to reach a global customer base.</p>
        </div>
    </div>
</div>
</section>

<!-- Core Values Section -->
<section class="values-section">
    <div class="container">
        <div class="section-header">
            <p class="section-subtitle">What We Stand For</p>
            <h2 class="section-title">Our Core Values</h2>
            <p class="section-description">The principles that guide our business and relationships with our partners.</p>
        </div>
        
        <div class="values-container">
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <h3 class="value-title">Quality Assurance</h3>
                <p class="value-text">We are committed to delivering 100% genuine export surplus garments that meet the highest quality standards.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="value-title">Ethical Practices</h3>
                <p class="value-text">We believe in fair trade, sustainable sourcing, and maintaining ethical relationships with all our partners.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3 class="value-title">Innovation</h3>
                <p class="value-text">We continuously adapt to market trends and embrace technological advancements to stay ahead in the industry.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="value-title">Customer Focus</h3>
                <p class="value-text">We prioritize our clients' needs and strive to exceed their expectations through personalized service.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h3 class="value-title">Global Vision</h3>
                <p class="value-text">We aim to connect British fashion with markets worldwide, bridging cultures through style.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3 class="value-title">Sustainability</h3>
                <p class="value-text">We are committed to environmentally responsible practices throughout our supply chain.</p>
            </div>
        </div>
    </div>
</section>

<!-- Quote Section -->
<section class="quote-section">
    <div class="quote-overlay"></div>
    <div class="container">
        <div class="quote-content">
            <div class="quote-text">
                <span class="quote-mark left">"</span>
                Fashion is not just about clothes; it's about creating connections and sharing Britain's rich design heritage with the world.
                <span class="quote-mark right">"</span>
            </div>
            <p style="margin-top: 30px; font-style: italic;">- Jane Smith, Co-founder</p>
        </div>
    </div>
</section>

<!-- Awards Section -->
<section class="awards-section">
    <div class="container">
        <div class="section-header">
            <p class="section-subtitle">Recognition</p>
            <h2 class="section-title">Our Achievements</h2>
            <p class="section-description">Awards and accolades that celebrate our commitment to excellence in the fashion industry.</p>
        </div>
        
        <div class="awards-container">
            <div class="award-card">
                <div class="award-image">
                    <img src="/images/award1.jpg" alt="Best Export Company Award">
                </div>
                <div class="award-content">
                    <h3 class="award-title">Best Export Company</h3>
                    <span class="award-year">2023</span>
                    <p class="award-description">Recognized by the British Fashion Council for excellence in fashion export services and global market development.</p>
                </div>
            </div>
            
            <div class="award-card">
                <div class="award-image">
                    <img src="/images/award2.jpg" alt="Sustainable Business Award">
                </div>
                <div class="award-content">
                    <h3 class="award-title">Sustainable Business Award</h3>
                    <span class="award-year">2022</span>
                    <p class="award-description">Awarded for implementing environmentally responsible practices throughout our supply chain and operations.</p>
                </div>
            </div>
            
            <div class="award-card">
                <div class="award-image">
                    <img src="/images/award3.jpg" alt="E-Commerce Innovation Award">
                </div>
                <div class="award-content">
                    <h3 class="award-title">E-Commerce Innovation</h3>
                    <span class="award-year">2022</span>
                    <p class="award-description">Recognized for our pioneering work with Fashion Global, revolutionizing wholesale fashion e-commerce.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Partner With Lady London</h2>
            <p class="cta-text">Join our global network of fashion retailers and distributors. Let's build successful business relationships that bring British fashion to new markets.</p>
            <a href="contact.php" class="cta-button">Get In Touch</a>
        </div>
    </div>
</section>

<!-- Footer -->
    <!-- Footer -->
<?php
    include 'footer.php';
?>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

<!-- Custom JavaScript -->
<script>
    // Mobile menu toggle
    document.getElementById('menuToggle').addEventListener('click', function() {
        document.getElementById('navLinks').classList.toggle('active');
    });
    
    // Scroll behavior
    document.addEventListener('DOMContentLoaded', function() {
        // Add scroll animation for elements
        const scrollElements = document.querySelectorAll('.story-container, .timeline-item, .value-card, .award-card');
        
        const elementInView = (el, dividend = 1) => {
            const elementTop = el.getBoundingClientRect().top;
            return (
                elementTop <= (window.innerHeight || document.documentElement.clientHeight) / dividend
            );
        };
        
        const displayScrollElement = (element) => {
            element.classList.add('scrolled');
        };
        
        const handleScrollAnimation = () => {
            scrollElements.forEach((el) => {
                if (elementInView(el, 1.25)) {
                    displayScrollElement(el);
                }
            });
        };
        
        window.addEventListener('scroll', () => {
            handleScrollAnimation();
        });
        
        // Trigger on initial load
        handleScrollAnimation();
    });
</script>
</body>
</html>