<?php

$catalogueCategories = [
    [
        'id' => 'wayfinding-signs',
        'title' => 'Wayfinding Signs',
        'copy' => 'Directional signs for lobbies, tower cores, lift zones, parking decks, and shared circulation routes.',
        'highlights' => ['Lift lobbies and floor directories', 'Directional arrows and landmark markers', 'Consistent branding across multiple blocks'],
    ],
    [
        'id' => 'notice-boards',
        'title' => 'Notice Boards',
        'copy' => 'Management notice boards and communication panels for announcements, circulars, and resident updates.',
        'highlights' => ['Indoor and semi-outdoor placements', 'Magnetic, acrylic, and lockable formats', 'Sized for management offices and common areas'],
    ],
    [
        'id' => 'safety-warning-signs',
        'title' => 'Safety Warning Signs',
        'copy' => 'Mandatory, hazard, and warning signage designed to improve safety awareness in shared residential and commercial spaces.',
        'highlights' => ['Fire, electrical, and caution signage', 'Clear icon-driven communication', 'Durable finishes for high-traffic environments'],
    ],
    [
        'id' => 'condominium-indoor-signage',
        'title' => 'Condominium Indoor Signage',
        'copy' => 'Interior signage systems including LED displays and 3D lettering for reception areas, corridors, and amenities.',
        'highlights' => ['LED feature signage', '3D lettering and branded wall signage', 'Lift lobby, corridor, and facility identification'],
    ],
    [
        'id' => 'condominium-outdoor-signage',
        'title' => 'Condominium Outdoor Signage',
        'copy' => 'Exterior signage solutions such as frontlit, backlit, and lightbox systems engineered for visibility and weather exposure.',
        'highlights' => ['Main entrance branding', 'Frontlit, backlit, and lightbox fabrication', 'Built for outdoor visibility and maintenance access'],
    ],
    [
        'id' => 'custom-number-signage',
        'title' => 'Custom Number Signage',
        'copy' => 'Unit numbers, block identifiers, and customized numbering systems for clear property identification.',
        'highlights' => ['Unit doors and parcel room labels', 'Block, floor, and bay numbering', 'Styles aligned with property branding'],
    ],
    [
        'id' => 'carpark-signage',
        'title' => 'Carpark Signage',
        'copy' => 'Traffic and parking signage that improves flow, safety, and level recognition throughout basement and podium parking areas.',
        'highlights' => ['Entry, exit, and directional markers', 'Reserved lot and level identification', 'Painted, mounted, and suspended options'],
    ],
    [
        'id' => 'advertising-signage',
        'title' => 'Advertising Signage',
        'copy' => 'Promotional and branding displays for campaigns, launches, and shared-property marketing placements.',
        'highlights' => ['Promotional display panels', 'Short-term and long-term campaign formats', 'Suitable for foyers, event zones, and storefronts'],
    ],
    [
        'id' => 'door-signage',
        'title' => 'Door Signage',
        'copy' => 'Door signs and room identifiers that make office, utility, and facility access clearer for residents and visitors.',
        'highlights' => ['Office, service room, and utility labels', 'Readable at close range and corridor distance', 'Available in engraved, acrylic, and metal finishes'],
    ],
    [
        'id' => 'amenity-signage',
        'title' => 'Amenity Signage',
        'copy' => 'Facility markers and rules signage for gyms, pools, halls, lounges, and other shared amenity areas.',
        'highlights' => ['Amenity naming and rule boards', 'Designed to match shared-space interiors', 'Supports better guest and resident navigation'],
    ],
];

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
        ['key' => 'home', 'label' => 'Home', 'href' => '#home'],
        ['key' => 'about', 'label' => 'About Us', 'href' => '#about'],
        ['key' => 'catalogue', 'label' => 'Product Catalogue', 'href' => '#products'],
        ['key' => 'contact', 'label' => 'Contact Us', 'href' => '#contact'],
        ['key' => 'projects', 'label' => 'Projects', 'href' => '#projects'],
        ['key' => 'services', 'label' => 'Services', 'href' => '#services'],
    ],
    'heroSlides' => [
        [
            'className' => 'slide-one',
            'tag' => 'Professional Signage Solutions',
            'title' => 'Clear, durable signage designed for condominium environments.',
            'titleTag' => 'h1',
            'copy' => 'Condo Signage helps property managers and developers present a polished building identity with compliant, durable, and management-approved signage systems.',
            'actions' => [
                ['label' => 'Explore Products', 'href' => 'catalogue.php', 'className' => 'btn btn-brand btn-lg'],
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
        'image' => [
            'src' => 'assets/images/photo-team.png',
            'alt' => 'A&T Media team photo',
            'caption' => 'Our team combines production, design, installation, and quality control experience under one roof.',
        ],
        'paragraphs' => [
            'A&T Media Sdn. Bhd. is a printing and advertising company that provides signage design and creation in the Kuala Lumpur (KL) area. Our headquarters is situated at Ulu Tiram, Johor, Malaysia.',
            'We provide a variety of in-house support in production, design, marketing, on-site installation, and evaluation.',
            'Each product is produced by our experienced production team and quality checked by our senior production manager, who has 20 years of experience.',
            'Not only do we have a strong team, but we also have 10,000 square feet of production space and state-of-the-art equipment such as routers, lasers, UV printers, plotters, cutting beds, 3D lettering machines, and automatic welding machines.',
        ],
    ],
    'sections' => [
        'products' => [
            'tag' => 'Products',
            'title' => 'Signage categories for every key touchpoint.',
            'copy' => 'Our product range is structured to support navigation, safety, communication, and brand presentation across the entire property.',
            'items' => array_map(
                static fn(array $category): array => [
                    'title' => $category['title'],
                    'copy' => $category['copy'],
                ],
                $catalogueCategories
            ),
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
    'catalogue' => [
        'tag' => 'Product Catalogue',
        'title' => 'Signage categories arranged for condominium operations.',
        'copy' => 'Browse the full catalogue by category and jump directly to the signage systems your property needs.',
        'intro' => 'This page groups our condominium signage solutions into practical categories so management teams can review scope, function, and likely applications faster.',
        'categories' => $catalogueCategories,
    ],
    'services' => [
        'tag' => 'Services',
        'eyebrow' => 'Our Process',
        'title' => 'Structured & Management-Friendly',
        'copy' => 'Minimal disruption. Clear communication. Reliable delivery.',
        'steps' => [
            ['number' => '01', 'title' => 'Site Assessment', 'copy' => 'Visibility, layout & requirements'],
            ['number' => '02', 'title' => 'Design Mockup', 'copy' => 'Placement visuals for review & approval'],
            ['number' => '03', 'title' => 'Fabrication', 'copy' => 'Quality materials & workmanship'],
            ['number' => '04', 'title' => 'Installation', 'copy' => 'Safe, neat & coordinated execution'],
        ],
        'highlights' => [
            'Clear layout and placement planning for approvals',
            'Durable materials suitable for Malaysia\'s climate',
            'Professional appearance that enhances property value',
            'Experience working in occupied and managed buildings',
            'Smooth coordination with management and site teams',
            'Designed with long-term maintenance and visibility in mind.',
        ],
        'ctaTitle' => 'Looking for a Reliable Signage Partner?',
        'ctaCopy' => 'Whether it\'s a new development, signage replacement, or building upgrade, we provide solutions you can approve with confidence.',
        'ctaLinkLabel' => 'Contact us for a free consultation or site assessment.',
        'ctaLinkHref' => '#contact',
    ],
    'contact' => [
        'tag' => 'Contact Us',
        'title' => 'Reach Our Team',
        'copy' => 'Get in touch with our headquarters team for enquiries, quotation requests, and project discussions.',
        'branches' => [
            [
                'id' => 'branch',
                'label' => 'Branch',
                'active' => false,
                'office' => [
                    'name' => 'A&T Media Branch Office',
                    'registration' => 'Malaysia branch enquiries are coordinated through our central team.',
                    'addressLines' => [
                        'Branch visits are available by appointment for project coordination,',
                        'site review planning, and installation support.',
                    ],
                ],
                'contactBlocks' => [
                    ['label' => 'Contact No', 'value' => '+6016-701 3295'],
                    ['label' => 'Email Address', 'value' => 'antadv.rei@gmail.com'],
                ],
                'quickActions' => [
                    'phone' => ['label' => 'Call Us', 'value' => '+6016-701 3295', 'href' => 'tel:+60167013295'],
                    'email' => ['label' => 'Email Us', 'value' => 'antadv.rei@gmail.com', 'href' => 'mailto:antadv.rei@gmail.com'],
                ],
                'whatsApp' => [
                    'label' => 'WhatsApp Us',
                    'subLabel' => 'Click to chat',
                    'href' => 'https://wa.me/60167013295',
                ],
            ],
            [
                'id' => 'hq',
                'label' => 'HQ',
                'active' => true,
                'office' => [
                    'name' => 'A&T Media Sdn. Bhd.',
                    'registration' => '202501057902 (1659308-W)',
                    'addressLines' => [
                        '16, Jalan Nilam 1/6, Taman Teknologi Tinggi Subang,',
                        '47500 Subang Jaya, Selangor, Malaysia.',
                    ],
                ],
                'contactBlocks' => [
                    ['label' => 'Contact No', 'value' => '+6016-701 3295'],
                    ['label' => 'Email Address', 'value' => 'antadv.rei@gmail.com'],
                ],
                'quickActions' => [
                    'phone' => ['label' => 'Call Us', 'value' => '+6016-701 3295', 'href' => 'tel:+60167013295'],
                    'email' => ['label' => 'Email Us', 'value' => 'antadv.rei@gmail.com', 'href' => 'mailto:antadv.rei@gmail.com'],
                ],
                'whatsApp' => [
                    'label' => 'WhatsApp Us',
                    'subLabel' => 'Click to chat',
                    'href' => 'https://wa.me/60167013295',
                ],
            ],
            [
                'id' => 'branch-sg',
                'label' => 'Branch SG',
                'active' => false,
                'office' => [
                    'name' => 'A&T Media Singapore Branch',
                    'registration' => 'Singapore branch enquiries can be routed through our regional team.',
                    'addressLines' => [
                        'Please contact us to arrange Singapore project discussions,',
                        'quotation review, and cross-border signage coordination.',
                    ],
                ],
                'contactBlocks' => [
                    ['label' => 'Contact No', 'value' => '+6016-701 3295'],
                    ['label' => 'Email Address', 'value' => 'antadv.rei@gmail.com'],
                ],
                'quickActions' => [
                    'phone' => ['label' => 'Call Us', 'value' => '+6016-701 3295', 'href' => 'tel:+60167013295'],
                    'email' => ['label' => 'Email Us', 'value' => 'antadv.rei@gmail.com', 'href' => 'mailto:antadv.rei@gmail.com'],
                ],
                'whatsApp' => [
                    'label' => 'WhatsApp Us',
                    'subLabel' => 'Click to chat',
                    'href' => 'https://wa.me/60167013295',
                ],
            ],
        ],
        'formFields' => [
            ['id' => 'name', 'label' => 'Name*', 'type' => 'text', 'placeholder' => 'Enter name here', 'columnClass' => 'col-12'],
            ['id' => 'phone', 'label' => 'Contact Number*', 'type' => 'tel', 'placeholder' => 'Enter contact number here', 'columnClass' => 'col-md-7'],
            ['id' => 'email', 'label' => 'Email*', 'type' => 'email', 'placeholder' => 'Enter email address here', 'columnClass' => 'col-md-5'],
            ['id' => 'attachment', 'label' => 'Upload File (optional)', 'type' => 'file', 'columnClass' => 'col-12'],
            ['id' => 'message', 'label' => 'Message (optional)', 'type' => 'textarea', 'placeholder' => 'Enter message here', 'columnClass' => 'col-12', 'rows' => 5],
        ],
        'submitLabel' => 'Send Inquiry',
    ],
];