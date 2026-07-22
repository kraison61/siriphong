<!DOCTYPE html>
<html lang="th" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'ศิริพงษ์ เซอร์วิส | ซ่อมเครื่องดูดฝุ่นอุตสาหกรรม' }}</title>
  <meta name="description"
    content="{{ $description ?? 'ซ่อมเครื่องดูดฝุ่นอุตสาหกรรมครบวงจร ประสบการณ์กว่า 20 ปี รับซ่อมทุกยี่ห้อ รับประกันงาน' }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600;700;800&family=Chakra+Petch:wght@500;600;700&display=swap"
    rel="stylesheet">
  <link rel="icon" href="{{ config('data.favicon') }}" type="image/x-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('jsonld')
</head>

<body class="font-sans text-ink bg-white leading-relaxed overflow-x-hidden pb-[72px] md:pb-0">

  <!-- ============================================================ -->
  <!-- NAVBAR                                                       -->
  <!-- ============================================================ -->
  <x-frontend.navbar />

  <main id="main-content">
    <!-- ============================================================ -->
    <!-- HERO SECTION                                                 -->
    <!-- ============================================================ -->
    <x-frontend.hero />

    <!-- ============================================================ -->
    <!-- TRUST STRIP                                                  -->
    <!-- ============================================================ -->
    <x-frontend.trust />

    <!-- ============================================================ -->
    <!-- SERVICES SECTION                                             -->
    <!-- ============================================================ -->
    <x-frontend.services />

    <!-- ============================================================ -->
    <!-- WHY US SECTION                                               -->
    <!-- ============================================================ -->
    <x-frontend.why-us />

    <!-- ============================================================ -->
    <!-- PORTFOLIO SECTION                                            -->
    <!-- ============================================================ -->
    <x-frontend.portfolio />

    <!-- ============================================================ -->
    <!-- TESTIMONIALS                                                 -->
    <!-- ============================================================ -->
    <x-frontend.testimonials />

    <!-- ============================================================ -->
    <!-- PROCESS & CONDITIONS                                         -->
    <!-- ============================================================ -->
    <x-frontend.process />

    <!-- ============================================================ -->
    <!-- SHIPPING CALCULATOR                                          -->
    <!-- ============================================================ -->
    <x-frontend.cal />

    <!-- ============================================================ -->
    <!-- CONTACT SECTION                                              -->
    <!-- ============================================================ -->
    <x-frontend.contact />
  </main>

  <!-- ============================================================ -->
  <!-- FOOTER                                                       -->
  <!-- ============================================================ -->
  <x-frontend.footer />

  <!-- ============================================================ -->
  <!-- STICKY MOBILE LINE CTA (fixed bottom)                       -->
  <!-- ============================================================ -->
  <x-frontend.sticky-mobile />

  <!-- Back to top -->
  <button
    class="fixed right-5 bottom-22 md:bottom-6 z-[99] w-11 h-11 flex items-center justify-center rounded-full text-lg text-white bg-navy shadow-md opacity-0 pointer-events-none transition-all hover:bg-navy-mid hover:-translate-y-0.5 data-[show=true]:opacity-100 data-[show=true]:pointer-events-auto"
    id="back-top" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="กลับขึ้นด้านบน">
    <i class="bi bi-arrow-up" aria-hidden="true"></i>
  </button>

</body>

</html>