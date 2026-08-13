<?php
/* =========================================
   COMPONENTE DE BANNER REUTILIZÁVEL
   TECHMINDS EDUCATION
========================================= */

// Pega o título e subtítulo definidos na página ou usa valores padrão
$tituloBanner    = $bannerTitulo    ?? 'Título Padrão';
$subtituloBanner = $bannerSubtitulo ?? 'Subtítulo Padrão';
?>

<section class="banner-site">
    <h1><?= htmlspecialchars($tituloBanner); ?></h1>
    <p><?= htmlspecialchars($subtituloBanner); ?></p>
</section>

<style>
    .banner-site {
        background-color: #5e7037; /* Verde exato da tela de Conteúdos */
        color: #ffffff;
        text-align: center;
        padding: 35px 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        width: 100%;
    }

    .banner-site h1 {
        margin: 0 0 8px;
        font-size: 38px;
        font-weight: 700;
        color: #ffffff !important; /* Força o texto em branco */
        line-height: 1.2;
    }

    .banner-site p {
        margin: 0;
        font-size: 15px;
        font-weight: 400;
        opacity: 0.95;
        color: #ffffff !important; /* Força o texto em branco */
    }

    @media (max-width: 768px) {
        .banner-site {
            padding: 25px 15px;
        }
        .banner-site h1 {
            font-size: 28px;
        }
        .banner-site p {
            font-size: 14px;
        }
    }
</style>
