<?php
/**
 * Site settings and content. Edit contact details, services and clients here;
 * index.php and submit-enquiry.php both read from this file.
 */

date_default_timezone_set('Asia/Kolkata');

const SITE_NAME    = 'X Force Securities and Facility Management';
const PHONE_DISPLAY = '+91 70123 72501';
const PHONE_LINK    = 'tel:+917012372501';
const WHATSAPP_LINK = 'https://wa.me/917012372501';
const EMAIL         = 'info@xforcesecurities.com';

// Shown with the message in the About section. The photo goes in
// assets/images/managing-director.jpg (or .png / .webp).
const MD_NAME  = 'Jyothi Krishnan';
const MD_TITLE = 'Managing Director';

// Enquiry form: every enquiry is saved to ENQUIRY_FILE, then emailed to ENQUIRY_EMAIL.
const ENQUIRY_FILE  = __DIR__ . '/../data/enquiries.csv';
const ENQUIRY_EMAIL = EMAIL;

// Outgoing mail server. Enquiry emails are sent from SMTP_USER. The password is
// kept in includes/smtp-password.php, which git ignores so it never reaches
// GitHub; copy smtp-password.example.php to create it on each server.
const SMTP_HOST          = 'mail.xforcesecurities.com';
const SMTP_PORT          = 465; // SSL
const SMTP_USER          = 'info@xforcesecurities.com';
const SMTP_PASSWORD_FILE = __DIR__ . '/smtp-password.php';

$offices = [
    [
        'district' => 'Alappuzha',
        'lines'    => ['Chamavilayil Building', 'Thekkekara P.O., Kurathikadu', 'Mavelikara, Alappuzha'],
        'pin'      => '690107',
        'map'      => 'https://maps.app.goo.gl/WNwHppSxemttBBEYA?g_st=iwb',
    ],
    [
        'district' => 'Thiruvananthapuram',
        'lines'    => ['Ullasom, Thonnakkal P.O.', 'Mangalapuram', 'Thiruvananthapuram'],
        'pin'      => '695317',
        'map'      => 'https://maps.app.goo.gl/FRvSPe4iTy6MJcop9?g_st=iwb',
    ],
];

$services = [
    [
        'title'  => 'Security Guard Services',
        'footer' => 'Security Guards',
        'icon'   => 'bi-shield-check',
        'text'   => 'Uniformed guards for gates, lobbies, wards, hostels and parking — access control, visitor registers, patrols and night watch, by shift or round the clock.',
    ],
    [
        'title'  => 'Security Supervisor Services',
        'footer' => 'Security Supervisors',
        'icon'   => 'bi-person',
        'text'   => 'Supervisors who manage rosters, inspect posts, brief guards, handle incidents and report directly to your management.',
    ],
    [
        'title'  => 'Driver Guard Services',
        'footer' => 'Driver Guards',
        'icon'   => 'bi-car-front',
        'text'   => 'Drivers trained to also provide personal security — for executives, official visits and the safe movement of cash and valuables.',
    ],
    [
        'title'  => 'Housekeeping & Cleaning',
        'footer' => 'Housekeeping & Cleaning',
        'icon'   => 'bi-bucket',
        'text'   => 'Dedicated cleaning staff for wards, classrooms, guest rooms, washrooms and common areas, working to an agreed daily checklist.',
    ],
    [
        'title'  => 'Facility Management',
        'footer' => 'Facility Management',
        'icon'   => 'bi-grid',
        'text'   => 'Security, housekeeping and upkeep staff managed together under a single contract — one point of contact responsible for your entire premises.',
    ],
];

$sectors = [
    ['title' => 'Hospitals',          'icon' => 'bi-hospital',   'text' => 'Casualty and ward access control, visiting-hour management and patient-area housekeeping.'],
    ['title' => 'Colleges & Schools', 'icon' => 'bi-mortarboard', 'text' => 'Campus gates, hostels, examination days and safe student arrival and departure.'],
    ['title' => 'Hotels',             'icon' => 'bi-luggage',    'text' => 'Courteous lobby and parking security, event coverage and room housekeeping.'],
    ['title' => 'Malls & Retail',     'icon' => 'bi-bag',        'text' => 'Floor and entry security, loss prevention and opening and closing routines.'],
    ['title' => 'Banks & Corporates', 'icon' => 'bi-bank',       'text' => 'Branch and office security, cash-area vigilance and driver guards for executives.'],
    ['title' => 'Trusts & Apartments', 'icon' => 'bi-building',  'text' => 'Gate security, visitor and delivery registers, and common-area cleaning.'],
];

$clientGroups = [
    'Healthcare'             => ['TSC Hospital', 'YANS Medical Institute'],
    'Education & Trusts'     => ['Amrita Vishwa Vidyapeetham', 'Heera College of Engineering', 'S Vyasa College', 'Sree Sankara Trust', 'EK Nayanar Charitable Trust'],
    'Hospitality & Corporate' => ['Hotel Olivia International', 'Hotel Railview', 'Regency Group of Companies', 'TSCB Bank'],
    'Retail & Malls'         => ['Swayamwara', 'RK Wedding Mall', 'Mayoori Furniture and Electronics', 'Kunnil Hyper Market', 'Mall of Choice', 'NC Mall', 'Luxon Tata', 'QRS Retail Limited'],
    'Residential & Others'   => ['Sree Dhanya', 'Cotman Gardens', 'Nila Apartments'],
];

/** Escape a value for HTML output. */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Start the session used for the form's CSRF token and result message. */
function start_session(): void
{
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
}
