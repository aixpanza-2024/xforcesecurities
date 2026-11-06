<?php
require __DIR__ . '/includes/config.php';

start_session();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Result of a form post made without JavaScript (see submit-enquiry.php).
$result = $_SESSION['enquiry_result'] ?? null;
unset($_SESSION['enquiry_result']);

$old       = $result['old'] ?? [];
$errors    = $result['errors'] ?? [];
$oldValue  = fn (string $key): string => e($old[$key] ?? '');
$isInvalid = fn (string $key): string => isset($errors[$key]) ? ' is-invalid' : '';

$clients = array_merge(...array_values($clientGroups));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>X Force Securities and Facility Management</title>
    <meta name="description" content="Security guards, security supervisors, driver guards, housekeeping and complete facility management for hospitals, colleges, schools, hotels, malls, banks and residential communities.">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="preload" href="assets/fonts/inter-latin-wght-normal.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Elements only start hidden for the scroll animations when JavaScript runs. -->
    <script>document.documentElement.classList.add('reveal-ready');</script>
</head>
<body data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-root-margin="-110px 0px -60%">

<!-- Top bar -->
<div class="topbar">
    <div class="container d-flex justify-content-center justify-content-md-between align-items-center gap-3">
        <span class="d-none d-lg-inline topbar-services">Security Guards · Supervisors · Driver Guards · Housekeeping · Facility Management</span>
        <span class="d-flex gap-4 ms-lg-auto">
            <a href="<?= PHONE_LINK ?>"><?= PHONE_DISPLAY ?></a>
            <a href="mailto:<?= EMAIL ?>"><?= EMAIL ?></a>
        </span>
    </div>
</div>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg site-nav sticky-top" aria-label="Main">
    <div class="container">
        <a class="navbar-brand brand" href="#home">
            <img src="assets/images/logo-small.png" alt="" width="70" height="72">
            <span>
                <span class="brand-name">X Force Securities</span>
                <span class="brand-sub">And Facility Management</span>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#sectors">Sectors</a></li>
                <li class="nav-item"><a class="nav-link" href="#clients">Clients</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
            <a class="btn btn-ink btn-call ms-lg-4 mt-2 mt-lg-0" href="<?= PHONE_LINK ?>"><i class="bi bi-telephone" aria-hidden="true"></i> Call Now</a>
        </div>
    </div>
</nav>

<main>
    <!-- Hero -->
    <section class="hero" id="home">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-7">
                    <p class="eyebrow eyebrow-line eyebrow-gold" data-reveal="from-left">Security &amp; Facility Management</p>
                    <h1 data-reveal="from-left" style="--i: 1">Protecting the places people trust most.</h1>
                    <p class="hero-text" data-reveal="from-left" style="--i: 2">X Force Securities provides security guards, security supervisors, driver guards, housekeeping and complete facility management for hospitals, colleges, schools, hotels, malls, banks and residential communities.</p>
                    <div class="d-flex flex-wrap gap-3" data-reveal="from-left" style="--i: 3">
                        <a class="btn btn-gold btn-lg-site" href="#contact">Request a Quotation</a>
                        <a class="btn btn-line-dark btn-lg-site" href="<?= WHATSAPP_LINK ?>" target="_blank" rel="noopener">Chat on WhatsApp</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-frame" data-reveal="from-right" style="--i: 2">
                        <div class="hero-frame-inner">
                            <img src="assets/images/logo.png" alt="X Force Securities and Facility Management emblem" width="503" height="520">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service strip -->
    <div class="service-strip">
        <div class="container">
            <ul class="service-strip-list">
                <?php foreach ($services as $index => $service): ?>
                    <li data-reveal="from-left" style="--i: <?= $index ?>"><?= e($service['title']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- About -->
    <section class="section" id="about">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4" data-reveal="from-left">
                    <p class="eyebrow">About Us</p>
                    <h2 class="section-title">One partner for the safety and upkeep of your premises.</h2>
                </div>
                <div class="col-lg-8 about-body">
                    <p data-reveal="from-right">X Force Securities and Facility Management supplies trained manpower to institutions and businesses that need their premises secure, clean and running smoothly every day.</p>
                    <p data-reveal="from-right" style="--i: 1">Whether you need a single guard at the gate or a complete team of security and housekeeping staff, we plan the deployment around your site and keep a supervisor accountable for it.</p>
                    <div class="row g-3 mt-3">
                        <div class="col-sm-6" data-reveal="from-left">
                            <div class="fact-card">
                                <h3>Every kind of premises</h3>
                                <p>Hospitals, colleges, schools, hotels, malls, banks, trusts and apartments</p>
                            </div>
                        </div>
                        <div class="col-sm-6" data-reveal="from-left" style="--i: 1">
                            <div class="fact-card fact-card-gold">
                                <h3>Five services</h3>
                                <p>services under one contract — from security to complete facility management</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section class="section section-cream" id="services">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-5">
                <div data-reveal="from-left">
                    <p class="eyebrow">Our Services</p>
                    <h2 class="section-title mb-0">What we provide</h2>
                </div>
                <div data-reveal="from-right">
                    <a class="link-underlined" href="#contact">Discuss your requirement →</a>
                </div>
            </div>
            <div class="row g-4">
                <?php foreach ($services as $index => $service):
                    $isFeatured = $index === count($services) - 1; ?>
                    <div class="<?= $isFeatured ? 'col-lg-8' : 'col-md-6 col-lg-4' ?>" data-reveal="from-left" style="--i: <?= $index % 3 ?>">
                        <article class="service-card<?= $isFeatured ? ' service-card-dark' : '' ?>">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="service-icon"><i class="bi <?= $service['icon'] ?>" aria-hidden="true"></i></span>
                                <span class="service-number" aria-hidden="true"><?= sprintf('%02d', $index + 1) ?></span>
                            </div>
                            <h3><?= e($service['title']) ?></h3>
                            <p><?= e($service['text']) ?></p>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Sectors -->
    <section class="section" id="sectors">
        <div class="container">
            <div class="text-center mb-5" data-reveal="from-below">
                <p class="eyebrow">Sectors We Serve</p>
                <h2 class="section-title sectors-title mx-auto mb-0">Staffed for the way your premises work</h2>
            </div>
            <div class="row g-0 sector-grid">
                <?php foreach ($sectors as $index => $sector): ?>
                    <div class="col-md-6 col-lg-4 sector-cell" data-reveal="from-left" style="--i: <?= $index % 3 ?>">
                        <span class="sector-icon"><i class="bi <?= $sector['icon'] ?>" aria-hidden="true"></i></span>
                        <h3><?= e($sector['title']) ?></h3>
                        <p><?= e($sector['text']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Clients -->
    <section class="section section-dark" id="clients">
        <div class="container">
            <div class="row align-items-end gy-3 mb-5">
                <div class="col-lg-7" data-reveal="from-left">
                    <p class="eyebrow eyebrow-gold">Our Clients</p>
                    <h2 class="section-title mb-0">Some of our valued clients</h2>
                </div>
                <div class="col-lg-4 offset-lg-1" data-reveal="from-right">
                    <p class="clients-text mb-0">A few of the hospitals, institutions, hotels, retailers and residential communities that rely on our teams every day.</p>
                </div>
            </div>
        </div>

        <div class="client-marquee" data-reveal="from-right" style="--i: 1">
            <div class="client-track">
                <?php foreach ([false, true] as $isCopy): // Two identical lists make the scroll loop seamless. ?>
                    <ul class="client-list"<?= $isCopy ? ' aria-hidden="true"' : '' ?>>
                        <?php foreach ($clients as $client): ?>
                            <li class="client-card">
                                <span class="client-logo"><i class="bi bi-image" aria-hidden="true"></i></span>
                                <span class="client-name"><?= e($client) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="text-center mt-5" data-reveal="from-below">
            <button type="button" class="btn btn-line-gold" data-bs-toggle="modal" data-bs-target="#clientsModal">View all clients <i class="bi bi-grid ms-1" aria-hidden="true"></i></button>
        </div>
    </section>

    <!-- Call to action -->
    <section class="cta">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
            <h2 data-reveal="from-left">Need trained staff for your premises?</h2>
            <div class="d-flex flex-wrap gap-3" data-reveal="from-right">
                <a class="btn btn-white" href="<?= PHONE_LINK ?>">Call <?= PHONE_DISPLAY ?></a>
                <a class="btn btn-line-white" href="<?= WHATSAPP_LINK ?>" target="_blank" rel="noopener">WhatsApp us</a>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section class="section section-cream" id="contact">
        <div class="container">
            <div class="contact-card">
                <span class="contact-card-line" data-reveal="line" aria-hidden="true"></span>
                <div class="row g-0">
                    <div class="col-lg-5 contact-panel-col" data-reveal="from-left">
                        <div class="contact-panel">
                            <p class="eyebrow eyebrow-line eyebrow-gold">Contact</p>
                            <h2 class="section-title contact-title">Request a quotation</h2>
                            <p class="contact-text">Tell us about your premises and the services you need. Our team will get back to you with a deployment plan.</p>
                            <ul class="contact-list">
                                <li data-reveal="from-left" style="--i: 2">
                                    <span class="contact-icon"><i class="bi bi-telephone" aria-hidden="true"></i></span>
                                    <span class="contact-detail"><small>Phone</small><a href="<?= PHONE_LINK ?>"><?= PHONE_DISPLAY ?></a></span>
                                </li>
                                <li data-reveal="from-left" style="--i: 3">
                                    <span class="contact-icon"><i class="bi bi-envelope" aria-hidden="true"></i></span>
                                    <span class="contact-detail"><small>Email</small><a href="mailto:<?= EMAIL ?>"><?= EMAIL ?></a></span>
                                </li>
                                <li data-reveal="from-left" style="--i: 4">
                                    <span class="contact-icon contact-icon-whatsapp"><i class="bi bi-whatsapp" aria-hidden="true"></i></span>
                                    <span class="contact-detail"><small>WhatsApp</small><a href="<?= WHATSAPP_LINK ?>" target="_blank" rel="noopener"><?= PHONE_DISPLAY ?></a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-7" data-reveal="from-right">
                        <form class="enquiry-form" id="enquiryForm" action="submit-enquiry.php" method="post">
                            <div id="formStatus" role="status" aria-live="polite">
                                <?php if ($result): ?>
                                    <div class="alert <?= $result['ok'] ? 'alert-success' : 'alert-danger' ?>"><?= e($result['message']) ?></div>
                                <?php endif; ?>
                            </div>

                            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                            <!-- Spam trap: hidden from people, filled in by bots. -->
                            <div class="form-trap" aria-hidden="true">
                                <label for="website">Website</label>
                                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="row g-3 g-md-4">
                                <div class="col-md-6" data-reveal="from-left" style="--i: 2">
                                    <div class="form-floating field">
                                        <input class="form-control<?= $isInvalid('name') ?>" type="text" id="name" name="name" value="<?= $oldValue('name') ?>" placeholder=" " autocomplete="name" minlength="2" maxlength="100" required>
                                        <label for="name">Full name</label>
                                        <span class="field-line" aria-hidden="true"></span>
                                    </div>
                                    <div class="invalid-feedback" data-error-for="name"><?= e($errors['name'] ?? '') ?></div>
                                </div>
                                <div class="col-md-6" data-reveal="from-left" style="--i: 3">
                                    <div class="form-floating field">
                                        <input class="form-control<?= $isInvalid('organisation') ?>" type="text" id="organisation" name="organisation" value="<?= $oldValue('organisation') ?>" placeholder=" " autocomplete="organization" maxlength="150">
                                        <label for="organisation">Organisation (optional)</label>
                                        <span class="field-line" aria-hidden="true"></span>
                                    </div>
                                    <div class="invalid-feedback" data-error-for="organisation"><?= e($errors['organisation'] ?? '') ?></div>
                                </div>
                                <div class="col-md-6" data-reveal="from-left" style="--i: 4">
                                    <div class="form-floating field">
                                        <input class="form-control<?= $isInvalid('phone') ?>" type="tel" id="phone" name="phone" value="<?= $oldValue('phone') ?>" placeholder=" " autocomplete="tel" maxlength="22" required>
                                        <label for="phone">Phone</label>
                                        <span class="field-line" aria-hidden="true"></span>
                                    </div>
                                    <div class="invalid-feedback" data-error-for="phone"><?= e($errors['phone'] ?? '') ?></div>
                                </div>
                                <div class="col-md-6" data-reveal="from-left" style="--i: 5">
                                    <div class="form-floating field">
                                        <select class="form-select<?= $isInvalid('service') ?>" id="service" name="service" required>
                                            <?php foreach ($services as $service): ?>
                                                <option<?= ($old['service'] ?? '') === $service['title'] ? ' selected' : '' ?>><?= e($service['title']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="service">Service required</label>
                                        <span class="field-line" aria-hidden="true"></span>
                                    </div>
                                    <div class="invalid-feedback" data-error-for="service"><?= e($errors['service'] ?? '') ?></div>
                                </div>
                                <div class="col-12" data-reveal="from-left" style="--i: 6">
                                    <div class="form-floating field">
                                        <textarea class="form-control<?= $isInvalid('requirement') ?>" id="requirement" name="requirement" placeholder=" " maxlength="2000"><?= $oldValue('requirement') ?></textarea>
                                        <label for="requirement">Your requirement (optional)</label>
                                        <span class="field-line" aria-hidden="true"></span>
                                    </div>
                                    <div class="invalid-feedback" data-error-for="requirement"><?= e($errors['requirement'] ?? '') ?></div>
                                </div>
                                <div class="col-12" data-reveal="from-left" style="--i: 7">
                                    <button class="btn btn-ink btn-send" type="submit">
                                        <span class="btn-send-label">Send Enquiry</span>
                                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="offices">
                <p class="eyebrow eyebrow-line" data-reveal="from-left">Our Offices</p>
                <div class="row g-4">
                    <?php foreach ($offices as $index => $office): ?>
                        <div class="col-md-6" data-reveal="<?= $index === 0 ? 'from-left' : 'from-right' ?>" style="--i: <?= $index ?>">
                            <article class="office-card">
                                <span class="office-icon"><i class="bi bi-geo-alt" aria-hidden="true"></i></span>
                                <div>
                                    <h3><?= e($office['district']) ?></h3>
                                    <address>
                                        <strong><?= e(SITE_NAME) ?></strong>
                                        <?php foreach ($office['lines'] as $line): ?>
                                            <span><?= e($line) ?></span>
                                        <?php endforeach; ?>
                                    </address>
                                    <div class="office-meta">
                                        <span class="office-pin">PIN <?= e($office['pin']) ?></span>
                                        <?php if ($office['map'] !== ''): ?>
                                            <a class="office-map" href="<?= e($office['map']) ?>" target="_blank" rel="noopener">View on Google Maps <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="row gy-4 footer-main">
            <div class="col-lg-5 d-flex align-items-center">
                <a class="brand brand-footer" href="#home">
                    <img src="assets/images/logo-small.png" alt="" width="93" height="96" loading="lazy">
                    <span>
                        <span class="brand-name">X Force Securities</span>
                        <span class="brand-sub">And Facility Management</span>
                    </span>
                </a>
            </div>
            <div class="col-sm-6 col-lg-4">
                <h2>Services</h2>
                <ul>
                    <?php foreach ($services as $service): ?>
                        <li><a href="#services"><?= e($service['footer']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-sm-6 col-lg-3">
                <h2>Contact</h2>
                <ul class="footer-contact">
                    <li><a href="<?= PHONE_LINK ?>"><?= PHONE_DISPLAY ?></a></li>
                    <li><a href="mailto:<?= EMAIL ?>"><?= EMAIL ?></a></li>
                </ul>
                <a class="btn-whatsapp" href="<?= WHATSAPP_LINK ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp" title="Chat on WhatsApp"><i class="bi bi-whatsapp" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="footer-offices">
            <div class="row gy-3">
                <?php foreach ($offices as $office): ?>
                    <div class="col-md-6">
                        <address>
                            <i class="bi bi-geo-alt" aria-hidden="true"></i>
                            <span>
                                <strong><?= e($office['district']) ?></strong>
                                <?= e(implode(', ', $office['lines'])) ?> – <?= e($office['pin']) ?>
                            </span>
                        </address>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <p class="footer-copy">© <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</p>
    </div>
</footer>

<a class="btn-whatsapp whatsapp-float" href="<?= WHATSAPP_LINK ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp" title="Chat on WhatsApp"><i class="bi bi-whatsapp" aria-hidden="true"></i></a>

<!-- All clients -->
<div class="modal fade" id="clientsModal" tabindex="-1" aria-labelledby="clientsModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title section-title mb-0" id="clientsModalTitle">Our clients</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php foreach ($clientGroups as $group => $names): ?>
                    <h3 class="eyebrow client-group-title"><?= e($group) ?></h3>
                    <ul class="client-group">
                        <?php foreach ($names as $name): ?>
                            <li><?= e($name) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js" onerror="document.documentElement.classList.remove('reveal-ready')"></script>
</body>
</html>
