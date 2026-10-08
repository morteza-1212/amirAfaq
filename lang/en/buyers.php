<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Page Meta
    |--------------------------------------------------------------------------
    */
    'title' => 'For Buyers | Amir Afaq Gostar Pars',

    /*
    |--------------------------------------------------------------------------
    | Hero Section
    |--------------------------------------------------------------------------
    */
    'label' => 'For Buyers',
    'hero_title' => 'Submit Your Purchase Request and Receive the Best Offer',
    'hero_description' => 'Register your product, quantity, and destination details. Our export experts will review your request and contact you with a customized offer that meets your business needs.',

    /*
    |--------------------------------------------------------------------------
    | Request Section
    |--------------------------------------------------------------------------
    */
    'request_label' => 'Purchase Request',
    'request_title' => 'Tell Us What You Need',
    'request_description' => 'Fill in the form below with your requirements. The more details you provide, the faster and more accurate our offer will be.',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */
    'product' => 'Product',
    'product_placeholder' => 'e.g. Pistachio, Saffron, Dates...',

    'quantity' => 'Quantity',
    'quantity_placeholder' => 'e.g. 5 tons, 200 cartons...',

    'destination_country' => 'Destination Country',
    'destination_country_placeholder' => 'e.g. Germany, UAE, China...',

    'destination_port' => 'Destination Port',
    'destination_port_placeholder' => 'e.g. Hamburg, Jebel Ali, Shanghai...',

    'packaging' => 'Packaging',
    'packaging_bulk' => 'Bulk',
    'packaging_bag' => 'Bag',
    'packaging_box' => 'Box',
    'packaging_custom' => 'Custom Packaging',

    'delivery_time' => 'Delivery Time',
    'delivery_time_placeholder' => 'e.g. Within 30 days, Urgent...',

    /*
    |--------------------------------------------------------------------------
    | Incoterms
    |--------------------------------------------------------------------------
    */
    'incoterms' => 'Incoterms',
    'incoterm_exw' => 'EXW - Ex Works',
    'incoterm_fca' => 'FCA - Free Carrier',
    'incoterm_fob' => 'FOB - Free On Board',
    'incoterm_cfr' => 'CFR - Cost and Freight',
    'incoterm_cif' => 'CIF - Cost, Insurance and Freight',
    'incoterm_dap' => 'DAP - Delivered At Place',
    'incoterm_ddp' => 'DDP - Delivered Duty Paid',
    'incoterms_help_title' => 'What are Incoterms?',
    'incoterms_help_description' => 'Incoterms are international commercial terms that define the responsibilities of buyers and sellers in the shipping process, such as costs, insurance, and risk transfer.',

    /*
    |--------------------------------------------------------------------------
    | Payment Terms
    |--------------------------------------------------------------------------
    */
    'payment_terms' => 'Payment Terms',
    'payment_advance' => 'Advance Payment',
    'payment_lc' => 'Letter of Credit (L/C)',
    'payment_tt' => 'Telegraphic Transfer (T/T)',
    'payment_other' => 'Other',

    /*
    |--------------------------------------------------------------------------
    | Company & Contact Information
    |--------------------------------------------------------------------------
    */
    'company_information' => 'Company Information',
    'company_information_placeholder' => 'Please provide your company name, registration number, and a brief description of your business activities...',

    'contact_name' => 'Contact Name',
    'contact_name_placeholder' => 'Your full name',

    'email' => 'Email',
    'email_placeholder' => 'example@company.com',

    'phone' => 'Phone',
    'phone_placeholder' => '+49 123 456 7890',

    'message' => 'Additional Message',
    'message_placeholder' => 'Any extra information you would like to share with us...',

    /*
    |--------------------------------------------------------------------------
    | Form Actions
    |--------------------------------------------------------------------------
    */
    'select_option' => 'Select an option',
    'submit' => 'Submit Request',

    /*
    |--------------------------------------------------------------------------
    | CTA Section
    |--------------------------------------------------------------------------
    */
    'cta_label' => 'Partnership',
    'cta_title' => 'Looking for a Long-Term Export Partner?',
    'cta_description' => 'We offer flexible cooperation models for wholesalers, distributors, and retail chains. Contact us to discuss customized terms for your business.',
    'contact_us' => 'Contact Us',

    /*
    |--------------------------------------------------------------------------
    | Success & Validation Messages
    |--------------------------------------------------------------------------
    */
    'success_message' => 'Your request has been submitted successfully. Our team will contact you soon.',

    'validation' => [
        'errors_title' => 'Please fix the following errors:',
        'product_required'             => 'Please enter the product name.',
        'product_string'               => 'The product name must be a valid text.',
        'product_max'                  => 'The product name must not exceed 255 characters.',

        'quantity_required'            => 'Please enter the quantity.',
        'quantity_string'              => 'The quantity must be a valid text.',
        'quantity_max'                 => 'The quantity must not exceed 255 characters.',

        'destination_country_required' => 'Please enter the destination country.',
        'destination_country_string'   => 'The destination country must be a valid text.',
        'destination_country_max'      => 'The destination country must not exceed 255 characters.',

        'destination_port_string'      => 'The destination port must be a valid text.',
        'destination_port_max'         => 'The destination port must not exceed 255 characters.',

        'packaging_string'             => 'The packaging must be a valid text.',
        'packaging_max'                => 'The packaging must not exceed 255 characters.',

        'delivery_time_string'         => 'The delivery time must be a valid text.',
        'delivery_time_max'            => 'The delivery time must not exceed 255 characters.',

        'incoterms_string'             => 'The Incoterms value must be a valid text.',
        'incoterms_max'                => 'The Incoterms value must not exceed 10 characters.',

        'payment_terms_string'         => 'The payment terms must be a valid text.',
        'payment_terms_max'            => 'The payment terms must not exceed 50 characters.',

        'company_information_required' => 'Please provide your company information.',
        'company_information_string'   => 'The company information must be a valid text.',
        'company_information_max'      => 'The company information must not exceed 5000 characters.',

        'name_string'                  => 'The contact name must be a valid text.',
        'name_max'                     => 'The contact name must not exceed 255 characters.',

        'email_invalid'                => 'Please enter a valid email address.',
        'email_max'                    => 'The email must not exceed 255 characters.',

        'phone_string'                 => 'The phone number must be a valid text.',
        'phone_max'                    => 'The phone number must not exceed 50 characters.',

        'message_string'               => 'The message must be a valid text.',
        'message_max'                  => 'The message must not exceed 5000 characters.',
    ],

];
