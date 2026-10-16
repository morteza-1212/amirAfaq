{{-- resources/views/panelAdmin/support/index.blade.php --}}

@extends('panelAdmin.layouts.panel')

@section('title', 'مرکز پشتیبانی')

@section('styles')
  <style>
      /* =========================================================
   SUPPORT INDEX PAGE
========================================================= */

      /* =========================================================
         PAGE HEADER
      ========================================================= */
      .support-page-header {
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 16px;
          margin-bottom: 24px;
          padding: 22px 26px;
          background: linear-gradient(135deg, var(--sp-primary) 0%, var(--sp-primary-dark) 100%);
          border-radius: var(--sp-radius-lg);
          color: #fff;
          position: relative;
          overflow: hidden;
          box-shadow: var(--sp-shadow);
      }

      .support-page-header::before {
          content: '';
          position: absolute;
          top: -50%;
          left: -10%;
          width: 300px;
          height: 300px;
          border-radius: 50%;
          background: rgba(255, 255, 255, .05);
          pointer-events: none;
      }

      .support-page-header::after {
          content: '';
          position: absolute;
          bottom: -60%;
          right: -5%;
          width: 260px;
          height: 260px;
          border-radius: 50%;
          background: rgba(214, 168, 79, .12);
          pointer-events: none;
      }

      .support-page-header > div:first-child {
          position: relative;
          z-index: 1;
      }

      .support-page-header h1 {
          font-size: 22px;
          font-weight: 800;
          color: #fff;
          margin-bottom: 6px;
          letter-spacing: -.3px;
      }

      .support-page-header p {
          font-size: 13.5px;
          color: rgba(255, 255, 255, .78);
          line-height: 1.7;
      }

      .support-header-icon {
          width: 64px;
          height: 64px;
          border-radius: 18px;
          background: rgba(255, 255, 255, .12);
          backdrop-filter: blur(8px);
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 30px;
          color: #fff;
          flex-shrink: 0;
          position: relative;
          z-index: 1;
          animation: headerIconFloat 3s ease-in-out infinite;
      }

      @keyframes headerIconFloat {
          0%, 100% { transform: translateY(0); }
          50%      { transform: translateY(-6px); }
      }

      /* =========================================================
         STATS CARDS
      ========================================================= */
      .support-stats {
          display: grid;
          grid-template-columns: repeat(4, minmax(0, 1fr));
          gap: 16px;
          margin-bottom: 22px;
      }

      .support-stat-card {
          display: flex;
          align-items: center;
          gap: 14px;
          padding: 18px 20px;
          background: var(--sp-card);
          border: 1px solid var(--sp-border);
          border-radius: var(--sp-radius-lg);
          box-shadow: var(--sp-shadow-sm);
          transition: var(--sp-transition);
          position: relative;
          overflow: hidden;
      }

      .support-stat-card::after {
          content: '';
          position: absolute;
          top: 0;
          right: 0;
          width: 4px;
          height: 100%;
          background: transparent;
          transition: var(--sp-transition);
      }

      .support-stat-card:hover {
          transform: translateY(-3px);
          box-shadow: var(--sp-shadow);
          border-color: var(--sp-border-strong);
      }

      .support-stat-icon {
          width: 52px;
          height: 52px;
          border-radius: 14px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 24px;
          flex-shrink: 0;
          transition: var(--sp-transition);
      }

      .support-stat-card:hover .support-stat-icon {
          transform: scale(1.06) rotate(-3deg);
      }

      .stat-icon-blue {
          background: rgba(59, 130, 246, .12);
          color: #2563eb;
      }

      .stat-icon-orange {
          background: rgba(245, 158, 11, .14);
          color: #d97706;
      }

      .stat-icon-green {
          background: rgba(16, 185, 129, .12);
          color: #059669;
      }

      .stat-icon-gray {
          background: rgba(107, 114, 128, .12);
          color: #4b5563;
      }

      .support-stat-card > div:last-child {
          display: flex;
          flex-direction: column;
          gap: 3px;
          min-width: 0;
      }

      .support-stat-card span {
          font-size: 12.5px;
          color: var(--sp-muted);
          font-weight: 500;
          line-height: 1.4;
      }

      .support-stat-card strong {
          font-size: 24px;
          font-weight: 800;
          color: var(--sp-text);
          line-height: 1.1;
          letter-spacing: -.5px;
      }

      /* رنگ نوار کناری بر اساس نوع کارت */
      .support-stat-card:has(.stat-icon-blue)::after   { background: #3b82f6; }
      .support-stat-card:has(.stat-icon-orange)::after { background: #f59e0b; }
      .support-stat-card:has(.stat-icon-green)::after  { background: #10b981; }
      .support-stat-card:has(.stat-icon-gray)::after   { background: #6b7280; }

      /* =========================================================
         FILTER CARD
      ========================================================= */
      .support-filter-card {
          margin-bottom: 22px;
          padding: 18px 20px;
          background: var(--sp-card);
          border: 1px solid var(--sp-border);
          border-radius: var(--sp-radius-lg);
          box-shadow: var(--sp-shadow-sm);
      }

      .support-filter-form {
          display: grid;
          grid-template-columns: minmax(200px, 2fr) minmax(150px, 1fr) minmax(140px, 1fr) auto auto;
          gap: 12px;
          align-items: center;
      }

      .support-search-field {
          position: relative;
          display: flex;
          align-items: center;
      }

      .support-search-field > i {
          position: absolute;
          right: 14px;
          top: 50%;
          transform: translateY(-50%);
          font-size: 16px;
          color: var(--sp-muted);
          pointer-events: none;
          transition: var(--sp-transition);
      }

      .support-search-field input {
          width: 100%;
          height: 44px;
          padding: 0 42px 0 16px;
          border: 1.5px solid var(--sp-border);
          border-radius: var(--sp-radius);
          background: var(--sp-light);
          color: var(--sp-text);
          font-family: inherit;
          font-size: 13.5px;
          outline: none;
          transition: var(--sp-transition);
      }

      .support-search-field input::placeholder {
          color: #a0a8a2;
      }

      .support-search-field input:focus {
          border-color: var(--sp-primary);
          background: #fff;
          box-shadow: 0 0 0 4px rgba(27, 54, 30, .08);
      }

      .support-search-field:focus-within > i {
          color: var(--sp-primary);
      }

      .support-filter-form select {
          width: 100%;
          height: 44px;
          padding: 0 36px 0 16px;
          border: 1.5px solid var(--sp-border);
          border-radius: var(--sp-radius);
          background-color: var(--sp-light);
          color: var(--sp-text);
          font-family: inherit;
          font-size: 13.5px;
          outline: none;
          cursor: pointer;
          transition: var(--sp-transition);
          appearance: none;
          -webkit-appearance: none;
          -moz-appearance: none;
          background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%237a8a7d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'/%3e%3c/svg%3e");
          background-repeat: no-repeat;
          background-position: left 14px center;
          background-size: 16px;
      }

      [dir="rtl"] .support-filter-form select {
          background-position: left 14px center;
      }

      [dir="ltr"] .support-filter-form select {
          background-position: right 14px center;
          padding: 0 16px 0 36px;
      }

      .support-filter-form select:focus {
          border-color: var(--sp-primary);
          background-color: #fff;
          box-shadow: 0 0 0 4px rgba(27, 54, 30, .08);
      }

      .support-filter-button {
          height: 44px;
          padding: 0 22px;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
          border: 0;
          border-radius: var(--sp-radius);
          background: var(--sp-primary);
          color: #fff;
          font-family: inherit;
          font-size: 13.5px;
          font-weight: 600;
          cursor: pointer;
          white-space: nowrap;
          transition: var(--sp-transition);
          box-shadow: 0 4px 12px rgba(27, 54, 30, .2);
      }

      .support-filter-button:hover {
          background: var(--sp-primary-dark);
          transform: translateY(-1px);
          box-shadow: 0 6px 18px rgba(27, 54, 30, .28);
      }

      .support-filter-button i {
          font-size: 15px;
      }

      .support-reset-filter {
          height: 44px;
          padding: 0 16px;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          border: 1.5px solid var(--sp-border);
          border-radius: var(--sp-radius);
          background: transparent;
          color: var(--sp-muted);
          font-size: 13px;
          font-weight: 600;
          white-space: nowrap;
          cursor: pointer;
          transition: var(--sp-transition);
      }

      .support-reset-filter:hover {
          background: var(--sp-danger-bg);
          color: var(--sp-danger);
          border-color: rgba(239, 68, 68, .25);
      }

      /* =========================================================
         TABLE CARD
      ========================================================= */
      .support-table-card {
          background: var(--sp-card);
          border: 1px solid var(--sp-border);
          border-radius: var(--sp-radius-lg);
          box-shadow: var(--sp-shadow-sm);
          overflow: hidden;
      }

      .support-table-heading {
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 12px;
          padding: 18px 22px;
          border-bottom: 1px solid var(--sp-border);
          flex-wrap: wrap;
      }

      .support-table-heading h2 {
          font-size: 16px;
          font-weight: 700;
          color: var(--sp-text);
          display: flex;
          align-items: center;
          gap: 8px;
      }

      .support-table-heading h2::before {
          content: '';
          width: 4px;
          height: 20px;
          border-radius: 4px;
          background: var(--sp-secondary);
      }

      .support-result-count {
          display: inline-flex;
          align-items: center;
          padding: 5px 14px;
          border-radius: 20px;
          background: rgba(27, 54, 30, .07);
          color: var(--sp-primary);
          font-size: 12.5px;
          font-weight: 600;
      }

      /* =========================================================
         TABLE
      ========================================================= */
      .support-table-responsive {
          overflow-x: auto;
          -webkit-overflow-scrolling: touch;
      }

      .support-table-responsive::-webkit-scrollbar {
          height: 8px;
      }

      .support-table-responsive::-webkit-scrollbar-thumb {
          background: rgba(27, 54, 30, .2);
          border-radius: 4px;
      }

      .support-table {
          width: 100%;
          border-collapse: separate;
          border-spacing: 0;
          font-size: 13.5px;
      }

      .support-table thead th {
          padding: 14px 18px;
          text-align: right;
          font-size: 12.5px;
          font-weight: 700;
          color: var(--sp-muted);
          text-transform: uppercase;
          letter-spacing: .3px;
          background: var(--sp-light);
          border-bottom: 1px solid var(--sp-border);
          white-space: nowrap;
      }

      [dir="ltr"] .support-table thead th {
          text-align: left;
      }

      .support-table tbody td {
          padding: 16px 18px;
          text-align: right;
          border-bottom: 1px solid var(--sp-border);
          vertical-align: middle;
          color: var(--sp-text);
      }

      [dir="ltr"] .support-table tbody td {
          text-align: left;
      }

      .support-table tbody tr {
          transition: var(--sp-transition);
      }

      .support-table tbody tr:hover {
          background: rgba(27, 54, 30, .025);
      }

      .support-table tbody tr:last-child td {
          border-bottom: 0;
      }

      /* =========================================================
         CONVERSATION ID CELL
      ========================================================= */
      .support-conversation-id {
          display: flex;
          align-items: center;
          gap: 12px;
          min-width: 0;
      }

      .support-avatar {
          width: 42px;
          height: 42px;
          border-radius: 12px;
          background: linear-gradient(135deg, rgba(27, 54, 30, .12), rgba(27, 54, 30, .06));
          color: var(--sp-primary);
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 18px;
          flex-shrink: 0;
      }

      .support-conversation-id > div {
          display: flex;
          flex-direction: column;
          gap: 3px;
          min-width: 0;
      }

      .support-conversation-id strong {
          font-size: 13.5px;
          font-weight: 700;
          color: var(--sp-text);
          font-family: 'Courier New', monospace;
          direction: ltr;
          display: inline-block;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          max-width: 140px;
      }

      .support-conversation-id small {
          font-size: 11.5px;
          color: var(--sp-muted);
          font-weight: 500;
      }

      /* =========================================================
         LANGUAGE BADGE
      ========================================================= */
      .support-language {
          display: inline-flex;
          align-items: center;
          padding: 4px 12px;
          border-radius: 20px;
          background: rgba(59, 130, 246, .1);
          color: #1e40af;
          font-size: 12px;
          font-weight: 600;
          white-space: nowrap;
      }

      /* =========================================================
         LAST MESSAGE CELL
      ========================================================= */
      .support-last-message {
          max-width: 280px;
          color: var(--sp-text-soft) !important;
          font-size: 13px;
          line-height: 1.6;
      }

      /* =========================================================
         DATE CELL
      ========================================================= */
      .support-date {
          font-size: 12.5px;
          color: var(--sp-muted);
          font-weight: 500;
          white-space: nowrap;
          direction: ltr;
          display: inline-block;
      }

      /* =========================================================
         OPEN CHAT BUTTON
      ========================================================= */
      .support-open-chat {
          display: inline-flex;
          align-items: center;
          gap: 7px;
          padding: 8px 14px;
          border-radius: var(--sp-radius-sm);
          background: rgba(27, 54, 30, .06);
          color: var(--sp-primary);
          font-size: 12.5px;
          font-weight: 600;
          white-space: nowrap;
          transition: var(--sp-transition);
          border: 1.5px solid transparent;
      }

      .support-open-chat:hover {
          background: var(--sp-primary);
          color: #fff;
          transform: translateY(-1px);
          box-shadow: 0 4px 12px rgba(27, 54, 30, .22);
      }

      .support-open-chat i {
          font-size: 14px;
      }

      /* =========================================================
         EMPTY STATE
      ========================================================= */
      .support-empty-state {
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          gap: 10px;
          padding: 60px 20px;
          text-align: center;
      }

      .support-empty-state i {
          font-size: 56px;
          color: var(--sp-primary);
          opacity: .3;
          margin-bottom: 6px;
      }

      .support-empty-state h3 {
          font-size: 16px;
          font-weight: 700;
          color: var(--sp-text);
          margin: 0;
      }

      .support-empty-state p {
          font-size: 13.5px;
          color: var(--sp-muted);
          line-height: 1.7;
          max-width: 320px;
      }

      /* =========================================================
         PAGINATION
      ========================================================= */
      .support-pagination {
          padding: 18px 22px;
          border-top: 1px solid var(--sp-border);
          display: flex;
          justify-content: center;
      }

      .support-pagination nav {
          display: flex;
          justify-content: center;
          width: 100%;
      }

      /* Laravel default pagination tweaks */
      .support-pagination .pagination {
          display: flex;
          align-items: center;
          gap: 5px;
          list-style: none;
          padding: 0;
          margin: 0;
          flex-wrap: wrap;
          justify-content: center;
      }

      .support-pagination .page-item {
          display: inline-block;
      }

      .support-pagination .page-link,
      .support-pagination .page-item > span,
      .support-pagination .page-item > a {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          min-width: 36px;
          height: 36px;
          padding: 0 10px;
          border-radius: var(--sp-radius-sm);
          background: var(--sp-light);
          color: var(--sp-text);
          font-size: 13px;
          font-weight: 600;
          text-decoration: none;
          border: 1px solid transparent;
          transition: var(--sp-transition);
      }

      .support-pagination .page-link:hover,
      .support-pagination .page-item > a:hover {
          background: rgba(27, 54, 30, .08);
          color: var(--sp-primary);
      }

      .support-pagination .page-item.active .page-link,
      .support-pagination .page-item.active > span {
          background: var(--sp-primary);
          color: #fff;
          border-color: var(--sp-primary);
          box-shadow: 0 4px 12px rgba(27, 54, 30, .25);
      }

      .support-pagination .page-item.disabled .page-link,
      .support-pagination .page-item.disabled > span {
          opacity: .45;
          cursor: not-allowed;
          background: var(--sp-light);
          color: var(--sp-muted);
      }

      /* =========================================================
         RESPONSIVE - TABLET
      ========================================================= */
      @media (max-width: 1199.98px) {
          .support-stats {
              grid-template-columns: repeat(2, minmax(0, 1fr));
          }

          .support-filter-form {
              grid-template-columns: minmax(200px, 1fr) minmax(150px, 1fr) minmax(140px, 1fr);
          }

          .support-filter-button,
          .support-reset-filter {
              grid-column: span 1;
          }
      }

      /* =========================================================
         RESPONSIVE - MOBILE
      ========================================================= */
      @media (max-width: 991.98px) {
          .support-page-header {
              padding: 18px 20px;
          }

          .support-page-header h1 {
              font-size: 19px;
          }

          .support-header-icon {
              width: 52px;
              height: 52px;
              font-size: 24px;
              border-radius: 14px;
          }

          .support-filter-form {
              grid-template-columns: 1fr 1fr;
          }

          .support-search-field {
              grid-column: 1 / -1;
          }

          .support-filter-button {
              grid-column: span 1;
          }

          .support-reset-filter {
              grid-column: 1 / -1;
          }

          .support-table {
              font-size: 13px;
          }

          .support-table thead th,
          .support-table tbody td {
              padding: 12px 14px;
          }

          .support-last-message {
              max-width: 200px;
          }
      }

      @media (max-width: 767.98px) {
          .support-page-header {
              flex-direction: column;
              align-items: flex-start;
              gap: 14px;
              padding: 18px;
          }

          .support-header-icon {
              position: absolute;
              top: 18px;
              left: 18px;
              width: 46px;
              height: 46px;
              font-size: 22px;
          }

          [dir="ltr"] .support-header-icon {
              left: auto;
              right: 18px;
          }

          .support-stats {
              grid-template-columns: 1fr 1fr;
              gap: 12px;
          }

          .support-stat-card {
              padding: 14px 16px;
              gap: 11px;
          }

          .support-stat-icon {
              width: 44px;
              height: 44px;
              font-size: 20px;
              border-radius: 12px;
          }

          .support-stat-card strong {
              font-size: 20px;
          }

          .support-stat-card span {
              font-size: 11.5px;
          }

          .support-filter-form {
              grid-template-columns: 1fr;
              gap: 10px;
          }

          .support-filter-button,
          .support-reset-filter {
              grid-column: 1 / -1;
              width: 100%;
          }

          .support-table-heading {
              padding: 14px 16px;
          }

          .support-table-heading h2 {
              font-size: 15px;
          }

          .support-result-count {
              font-size: 11.5px;
              padding: 4px 11px;
          }

          /* Hide less important columns on mobile */
          .support-table thead th:nth-child(2),
          .support-table tbody td:nth-child(2),
          .support-table thead th:nth-child(5),
          .support-table tbody td:nth-child(5) {
              display: none;
          }

          .support-table thead th,
          .support-table tbody td {
              padding: 11px 12px;
          }

          .support-avatar {
              width: 36px;
              height: 36px;
              font-size: 15px;
              border-radius: 10px;
          }

          .support-conversation-id strong {
              font-size: 12.5px;
              max-width: 100px;
          }

          .support-conversation-id small {
              font-size: 10.5px;
          }

          .support-last-message {
              max-width: 160px;
              font-size: 12.5px;
          }

          .support-open-chat {
              padding: 7px 11px;
              font-size: 11.5px;
          }

          .support-open-chat span {
              display: none;
          }

          .support-pagination {
              padding: 14px 16px;
          }

          .support-pagination .page-link,
          .support-pagination .page-item > span,
          .support-pagination .page-item > a {
              min-width: 32px;
              height: 32px;
              font-size: 12px;
          }
      }

      @media (max-width: 575.98px) {
          .support-page {
              padding: 12px;
          }

          .support-page-header h1 {
              font-size: 17px;
          }

          .support-page-header p {
              font-size: 12.5px;
          }

          .support-stats {
              gap: 10px;
          }

          .support-stat-card {
              flex-direction: column;
              align-items: flex-start;
              gap: 8px;
              padding: 12px 14px;
          }

          .support-stat-card strong {
              font-size: 18px;
          }

          .support-stat-icon {
              width: 38px;
              height: 38px;
              font-size: 18px;
              border-radius: 10px;
          }

          /* Hide language & date columns on very small screens */
          .support-table thead th:nth-child(2),
          .support-table tbody td:nth-child(2),
          .support-table thead th:nth-child(5),
          .support-table tbody td:nth-child(5) {
              display: none;
          }

          .support-table thead th,
          .support-table tbody td {
              padding: 10px 10px;
              font-size: 12px;
          }

          .support-conversation-id {
              gap: 8px;
          }

          .support-avatar {
              width: 32px;
              height: 32px;
              font-size: 14px;
          }

          .support-conversation-id strong {
              font-size: 11.5px;
              max-width: 80px;
          }

          .support-conversation-id small {
              font-size: 10px;
          }

          .support-last-message {
              max-width: 120px;
              font-size: 11.5px;
              line-height: 1.5;
          }

          .support-open-chat {
              padding: 6px 10px;
              font-size: 11px;
          }

          .support-open-chat i {
              font-size: 13px;
          }

          .support-empty-state {
              padding: 40px 14px;
          }

          .support-empty-state i {
              font-size: 44px;
          }

          .support-empty-state h3 {
              font-size: 14px;
          }

          .support-empty-state p {
              font-size: 12.5px;
          }

          .support-pagination .page-link,
          .support-pagination .page-item > span,
          .support-pagination .page-item > a {
              min-width: 30px;
              height: 30px;
              padding: 0 8px;
              font-size: 11.5px;
          }
      }

      /* =========================================================
         REDUCED MOTION
      ========================================================= */
      @media (prefers-reduced-motion: reduce) {
          .support-page-header::before,
          .support-page-header::after,
          .support-header-icon {
              animation: none !important;
          }
      }
  </style>
@endsection

@section('content')
    <div class="support-page">

        <div class="support-page-header">
            <div>
                <h1>مرکز پشتیبانی</h1>
                <p>مدیریت گفتگوها و پاسخ‌گویی به مشتریان</p>
            </div>

            <div class="support-header-icon">
                <i class="bi bi-headset"></i>
            </div>
        </div>

        {{-- آمار مکالمات --}}
        <div class="support-stats">
            <div class="support-stat-card">
                <div class="support-stat-icon stat-icon-blue">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <div>
                    <span>کل مکالمات</span>
                    <strong>{{ $stats['total'] ?? 0 }}</strong>
                </div>
            </div>

            <div class="support-stat-card">
                <div class="support-stat-icon stat-icon-orange">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <span>منتظر پاسخ</span>
                    <strong>{{ $stats['waiting'] ?? 0 }}</strong>
                </div>
            </div>

            <div class="support-stat-card">
                <div class="support-stat-icon stat-icon-green">
                    <i class="bi bi-person-check"></i>
                </div>
                <div>
                    <span>اختصاص‌یافته</span>
                    <strong>{{ $stats['assigned'] ?? 0 }}</strong>
                </div>
            </div>

            <div class="support-stat-card">
                <div class="support-stat-icon stat-icon-gray">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div>
                    <span>بسته‌شده</span>
                    <strong>{{ $stats['closed'] ?? 0 }}</strong>
                </div>
            </div>
        </div>

        {{-- فیلترها --}}
        <div class="support-filter-card">
            <form action="{{ route('admin.support.index') }}"
                  method="GET"
                  class="support-filter-form">

                <div class="support-search-field">
                    <i class="bi bi-search"></i>

                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="جست‌وجو بر اساس شناسه مکالمه...">
                </div>

                <select name="status" aria-label="فیلتر وضعیت">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="bot" @selected(request('status') === 'bot')>
                        پاسخ‌گویی خودکار
                    </option>
                    <option value="waiting_for_agent"
                        @selected(request('status') === 'waiting_for_agent')>
                        منتظر کارشناس
                    </option>
                    <option value="assigned"
                        @selected(request('status') === 'assigned')>
                        اختصاص‌یافته
                    </option>
                    <option value="closed"
                        @selected(request('status') === 'closed')>
                        بسته‌شده
                    </option>
                </select>

                <select name="locale" aria-label="فیلتر زبان">
                    <option value="">همه زبان‌ها</option>
                    <option value="fa" @selected(request('locale') === 'fa')>
                        فارسی
                    </option>
                    <option value="en" @selected(request('locale') === 'en')>
                        انگلیسی
                    </option>
                    <option value="ar" @selected(request('locale') === 'ar')>
                        عربی
                    </option>
                </select>

                <button type="submit" class="support-filter-button">
                    <i class="bi bi-funnel"></i>
                    اعمال فیلتر
                </button>

                @if(request()->hasAny(['q', 'status', 'locale']))
                    <a href="{{ route('admin.support.index') }}"
                       class="support-reset-filter">
                        پاک کردن فیلترها
                    </a>
                @endif
            </form>
        </div>

        {{-- جدول مکالمات --}}
        <div class="support-table-card">
            <div class="support-table-heading">
                <h2>مکالمات مشتریان</h2>

                <span class="support-result-count">
                {{ $conversations->total() }} مکالمه
            </span>
            </div>

            <div class="support-table-responsive">
                <table class="support-table">
                    <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>زبان</th>
                        <th>آخرین پیام</th>
                        <th>وضعیت</th>
                        <th>آخرین فعالیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($conversations as $conversation)
                        <tr>
                            <td>
                                <div class="support-conversation-id">
                                    <span class="support-avatar">
                                        <i class="bi bi-person"></i>
                                    </span>

                                    <div>
                                        <strong>
                                            {{ \Illuminate\Support\Str::limit(
                                                $conversation->public_id,
                                                14
                                            ) }}
                                        </strong>

                                        <small>
                                            مکالمه #{{ $conversation->id }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @php
                                    $locales = [
                                        'fa' => 'فارسی',
                                        'en' => 'English',
                                        'ar' => 'العربية',
                                    ];
                                @endphp

                                <span class="support-language">
                                    {{ $locales[$conversation->locale] ?? $conversation->locale }}
                                </span>
                            </td>

                            <td class="support-last-message">
                                {{ \Illuminate\Support\Str::limit(
                                    $conversation->latestMessage?->content
                                        ?? 'هنوز پیامی ثبت نشده است',
                                    65
                                ) }}
                            </td>

                            <td>
                                @include(
                                    'panelAdmin.chatbot.support.partials.conversation-status',
                                    ['status' => $conversation->status]
                                )
                            </td>

                            <td>
                                <span class="support-date">
                                    {{ $conversation->last_message_at
                                        ? \Illuminate\Support\Carbon::parse(
                                            $conversation->last_message_at
                                        )->format('Y/m/d H:i')
                                        : '—' }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('admin.support.chat', $conversation) }}"
                                   class="support-open-chat">
                                    <i class="bi bi-chat-left-text"></i>
                                    مشاهده گفتگو
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="support-empty-state">
                                    <i class="bi bi-chat-square-text"></i>
                                    <h3>مکالمه‌ای پیدا نشد</h3>
                                    <p>
                                        با تغییر فیلترها دوباره جست‌وجو کن.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($conversations->hasPages())
                <div class="support-pagination">
                    {{ $conversations->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
