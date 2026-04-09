<?php

$siteConfig = [
    'brand' => [
        'name' => 'Condo Signage',
        'company' => 'A&T Media Sdn. Bhd.',
        'tagline' => 'Professional condominium and commercial signage solutions.',
        'logo' => 'logo.jpg',
        'website' => 'www.antsignage.com',
    ],
    'meta' => [
        'title' => 'Condo Signage | Professional Signage Solutions',
        'description' => 'Condo Signage delivers professional signage solutions for condominiums and commercial properties, from design and fabrication to installation.',
    ],
    'nav' => [
        ['label' => 'Home', 'href' => '#home'],
        ['label' => 'About Us', 'href' => '#about'],
        ['label' => 'Product Catalogue', 'href' => '#products'],
        ['label' => 'Contact Us', 'href' => '#contact'],
        ['label' => 'Projects', 'href' => '#projects'],
        ['label' => 'Services', 'href' => '#services'],
    ],
    'heroSlides' => [
        [
            'className' => 'slide-one',
            'tag' => 'Professional Signage Solutions',
            'title' => 'Clear, durable signage designed for condominium environments.',
            'titleTag' => 'h1',
            'copy' => 'Condo Signage helps property managers and developers present a polished building identity with compliant, durable, and management-approved signage systems.',
            'actions' => [
                ['label' => 'Explore Products', 'href' => '#products', 'className' => 'btn btn-brand btn-lg'],
                ['label' => 'Learn More', 'href' => '#about', 'className' => 'btn btn-outline-light btn-lg'],
            ],
            'panel' => [
                'title' => 'Built for modern properties',
                'copy' => 'Wayfinding, safety signage, notice boards, amenity signs, and custom solutions produced with consistent branding and reliable materials.',
            ],
        ],
        [
            'className' => 'slide-two',
            'tag' => 'From Assessment To Installation',
            'title' => 'One team handling planning, fabrication, and on-site execution.',
            'titleTag' => 'h2',
            'copy' => 'We support each stage of the signage process, from site assessment and design mockups to fabrication and professional installation.',
            'metrics' => [
                ['number' => '01', 'label' => 'Site Assessment'],
                ['number' => '02', 'label' => 'Design Mockup'],
                ['number' => '03', 'label' => 'Installation'],
            ],
        ],
        [
            'className' => 'slide-three',
            'tag' => 'Trusted Product Range',
            'title' => 'Indoor and outdoor signage tailored to residential and commercial settings.',
            'titleTag' => 'h2',
            'copy' => 'Our product range covers notice boards, safety warning signs, door signage, car park signage, number plates, and custom branding displays.',
            'actions' => [
                ['label' => 'Talk To Our Team', 'href' => '#contact', 'className' => 'btn btn-brand btn-lg mt-3'],
            ],
        ],
    ],
    'about' => [
        'tag' => 'About Us',
        'title' => 'Reliable signage support for property management teams.',
        'paragraphs' => [
            'A&T Media Sdn. Bhd. provides signage, printing, and advertising solutions with a strong focus on quality presentation and long-term durability. Our team works closely with building owners, management offices, and developers to ensure each sign fits the property environment and communication needs.',
            'From condominium directories and notice boards to safety and amenity signs, we create signage that looks professional, communicates clearly, and performs well in daily use.',
        ],
        'features' => [
            ['title' => 'Professional Finish', 'copy' => 'Clean layouts, consistent branding, and durable materials suited for managed properties.'],
            ['title' => 'End-To-End Service', 'copy' => 'Site review, design mockup, fabrication, and installation managed by one team.'],
            ['title' => 'Indoor & Outdoor', 'copy' => 'Solutions for lobbies, corridors, lift areas, car parks, perimeters, and entry points.'],
            ['title' => 'Custom Production', 'copy' => 'Flexible specifications for sizes, materials, colors, and installation requirements.'],
        ],
    ],
    'sections' => [
        'products' => [
            'tag' => 'Products',
            'title' => 'Signage categories for every key touchpoint.',
            'copy' => 'Our product range is structured to support navigation, safety, communication, and brand presentation across the entire property.',
            'items' => [
                ['title' => 'Wayfinding Signs', 'copy' => 'Directional signs for lobbies, towers, parking levels, facilities, and common access routes.'],
                ['title' => 'Notice Boards', 'copy' => 'Management notice boards and communication panels for public updates and building announcements.'],
                ['title' => 'Safety Warning Signs', 'copy' => 'Mandatory and caution signage for safe operations in shared residential and commercial spaces.'],
                ['title' => 'Indoor Signage', 'copy' => 'Elegant room labels, floor directories, lift lobby signs, and resident-facing building information.'],
                ['title' => 'Outdoor Signage', 'copy' => 'Weather-ready signs for entrances, facility zones, parking access, and external property branding.'],
                ['title' => 'Custom Number Signage', 'copy' => 'Unit numbers, block identifiers, parking bay numbering, and other custom identification systems.'],
                ['title' => 'Car Park Signage', 'copy' => 'Traffic flow, level markers, reserved parking signs, and direction systems for safer circulation.'],
                ['title' => 'Advertising Signage', 'copy' => 'Branding displays, promotional installations, and communication visuals for shared environments.'],
                ['title' => 'Door & Amenity Signage', 'copy' => 'Room labels, facility markers, and amenity signs that elevate clarity and presentation.'],
            ],
        ],
        'projects' => [
            'tag' => 'Projects',
            'title' => 'Selected signage applications for managed properties.',
            'copy' => 'Representative project categories show how Condo Signage supports different property areas with coordinated visual systems.',
            'items' => [
                ['title' => 'Lobby Directories', 'copy' => 'Directory systems and identity signage for entrances, reception spaces, and shared arrival zones.'],
                ['title' => 'Car Park Navigation', 'copy' => 'Level identification, directional signs, and reserved bay systems for easier vehicle movement.'],
                ['title' => 'Amenity Signage Sets', 'copy' => 'Consistent signage packages for pools, gyms, multipurpose halls, and other shared facilities.'],
            ],
        ],
    ],
    'services' => [
        'tag' => 'Services',
        'title' => 'A straightforward workflow from brief to installation.',
        'copy' => 'We keep the process practical and transparent so property teams can review designs, approvals, and execution with confidence.',
        'steps' => [
            ['number' => '01', 'title' => 'Site Assessment'],
            ['number' => '02', 'title' => 'Design Mockup'],
            ['number' => '03', 'title' => 'Fabrication'],
            ['number' => '04', 'title' => 'Installation'],
        ],
    ],
    'contact' => [
        'tag' => 'Contact Us',
        'title' => 'Let’s discuss your signage requirements.',
        'copy' => 'If you need signage for a condominium, mixed development, or commercial building, our team can recommend suitable options for layout, material, and installation.',
        'details' => [
            ['label' => 'Company', 'value' => 'A&T Media Sdn. Bhd.'],
            ['label' => 'Coverage', 'value' => 'Kuala Lumpur, Johor, and surrounding project locations'],
            ['label' => 'Website', 'value' => 'www.antsignage.com'],
        ],
        'formFields' => [
            ['id' => 'name', 'label' => 'Name', 'type' => 'text', 'placeholder' => 'Your name', 'columnClass' => 'col-md-6'],
            ['id' => 'company', 'label' => 'Company', 'type' => 'text', 'placeholder' => 'Company name', 'columnClass' => 'col-md-6'],
            ['id' => 'email', 'label' => 'Email', 'type' => 'email', 'placeholder' => 'name@example.com', 'columnClass' => 'col-md-6'],
            ['id' => 'phone', 'label' => 'Phone', 'type' => 'tel', 'placeholder' => 'Your phone number', 'columnClass' => 'col-md-6'],
            ['id' => 'message', 'label' => 'Project Details', 'type' => 'textarea', 'placeholder' => 'Tell us about your signage requirements', 'columnClass' => 'col-12', 'rows' => 5],
        ],
        'submitLabel' => 'Send Inquiry',
    ],
];