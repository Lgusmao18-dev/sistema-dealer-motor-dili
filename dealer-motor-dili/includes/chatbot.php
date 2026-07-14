<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$chat_lang = $_SESSION['lang'] ?? 'tl';

// Helper translations specifically for the chatbot
$chat_translations = [
    'tl' => [
        'bot_name' => 'Asistent Dealer',
        'status' => 'Online & Pronto',
        'greeting' => 'Olá! Bem-vindo ba Dealer Motor Dili. Oinsa ami bele ajuda ita-boot ?',
        'menu_nearest' => '🔍 Buka Dealer Besik Liu (GPS)',
        'menu_hours' => '🕒 Oráriu Servisu Showroom',
        'menu_contact' => '📞 Kontaktu Ofisial Dealer',
        'menu_brands' => '🏍️ Buka Tuir Marka Motor',
        'input_placeholder' => 'Hakerek...',
        'gps_loading' => 'Deteta hela ita-boot nia lokasaun atuál...',
        'gps_denied' => 'Kbiit GPS la hetan autorizasaun. Favor ativa GPS iha telemovel ka browser.',
        'gps_unsupported' => 'Ita-boot nia browser la apoia Geolocation GPS.',
        'gps_nearest_res' => 'Tuir kalkulasaun distánsia GPS, dealer ne\'ebé <strong>besik liu</strong> ho ita-boot mak:',
        'brand_prompt' => 'Favor hili marka motor ne\'ebé ita-boot hakarak:',
        'hours_all' => 'Oráriu servisu jerál ba showroom hotu-hotu mak <strong>Segunda to\'o Sábadu, 08:00 - 17:00/18:00</strong>. Domingu taka.',
        'contact_intro' => 'Tuir mai mak lista kontaktu ofisial husi dealer sira iha Dili:',
        'direction_btn' => 'Haree Dalan',
        'map_focus_btn' => 'Haree iha Mapa',
        'typing' => 'Hakerek hela...',
        'no_match' => 'Deskulpa, ami la komprende pergunta ne\'e. Ita-boot bele hili opsaun menu iha okos ka ketak hakerek "Honda", "Yamaha", "Oras", ka "Kontaktu".',
        'km_away' => 'km husi ita'
    ],
    'pt' => [
        'bot_name' => 'Assistente de Concessionária',
        'status' => 'Online & Pronto',
        'greeting' => 'Olá! Bem-vindo à Dealer Motor Dili. Como posso ajudá-lo hoje?',
        'menu_nearest' => '🔍 Encontrar Concessionária Mais Próxima (GPS)',
        'menu_hours' => '🕒 Horário de Funcionamento',
        'menu_contact' => '📞 Contactos Oficiais das Concessionárias',
        'menu_brands' => '🏍️ Procurar por Marca de Moto',
        'input_placeholder' => 'Escreva...',
        'gps_loading' => 'A detetar a sua localização atual...',
        'gps_denied' => 'Permissão de GPS negada. Por favor, ative o GPS no seu telemóvel ou navegador.',
        'gps_unsupported' => 'O seu navegador não suporta Geolocalização GPS.',
        'gps_nearest_res' => 'De acordo com o cálculo de distância do GPS, a concessionária <strong>mais próxima</strong> de si é:',
        'brand_prompt' => 'Por favor, escolha a marca de moto que deseja:',
        'hours_all' => 'O horário geral de funcionamento dos showrooms é de <strong>Segunda a Sábado, das 08:00 às 17:00/18:00</strong>. Fechado aos Domingos.',
        'contact_intro' => 'Aqui está a lista de contactos oficiais das concessionárias em Dili:',
        'direction_btn' => 'Obter Direções',
        'map_focus_btn' => 'Ver no Mapa',
        'typing' => 'A digitar...',
        'no_match' => 'Desculpe, não entendi a sua pergunta. Pode escolher uma opção do menu abaixo ou digitar palavras-chave como "Honda", "Yamaha", "Horas" ou "Contacto".',
        'km_away' => 'km de si'
    ],
    'en' => [
        'bot_name' => 'Dealer Assistant',
        'status' => 'Online & Ready',
        'greeting' => 'Hello! Welcome to Dealer Motor Dili. How can I help you today?',
        'menu_nearest' => '🔍 Find Nearest Dealer (GPS)',
        'menu_hours' => '🕒 Showroom Working Hours',
        'menu_contact' => '📞 Official Dealer Contacts',
        'menu_brands' => '🏍️ Search by Motorcycle Brand',
        'input_placeholder' => 'Type here...',
        'gps_loading' => 'Detecting your current location...',
        'gps_denied' => 'GPS permission denied. Please enable GPS in your device or browser settings.',
        'gps_unsupported' => 'Your browser does not support GPS Geolocation.',
        'gps_nearest_res' => 'Based on GPS distance calculation, the <strong>nearest</strong> dealer to you is:',
        'brand_prompt' => 'Please select the motorcycle brand you are looking for:',
        'hours_all' => 'General working hours for showrooms are <strong>Monday to Saturday, 08:00 - 17:00/18:00</strong>. Closed on Sundays.',
        'contact_intro' => 'Here is the list of official contacts for dealers in Dili:',
        'direction_btn' => 'Get Directions',
        'map_focus_btn' => 'View on Map',
        'typing' => 'Typing...',
        'no_match' => 'Sorry, I didn\'t quite understand that. Please select an option from the menu below or type keywords like "Honda", "Yamaha", "Hours", or "Contact".',
        'km_away' => 'km away'
    ],
    'id' => [
        'bot_name' => 'Asisten Dealer',
        'status' => 'Online & Siap',
        'greeting' => 'Halo! Selamat datang di Dealer Motor Dili. Ada yang bisa kami bantu hari ini?',
        'menu_nearest' => '🔍 Cari Dealer Terdekat (GPS)',
        'menu_hours' => '🕒 Jam Operasional Showroom',
        'menu_contact' => '📞 Kontak Resmi Dealer',
        'menu_brands' => '🏍️ Cari Berdasarkan Merek Motor',
        'input_placeholder' => 'Tulis...',
        'gps_loading' => 'Mendeteksi lokasi Anda saat ini...',
        'gps_denied' => 'Izin GPS ditolak. Silakan aktifkan GPS pada ponsel atau pengaturan browser Anda.',
        'gps_unsupported' => 'Browser Anda tidak mendukung Geolokasi GPS.',
        'gps_nearest_res' => 'Berdasarkan kalkulasi jarak GPS, dealer yang <strong>terdekat</strong> dengan Anda adalah:',
        'brand_prompt' => 'Silakan pilih merek motor yang Anda inginkan:',
        'hours_all' => 'Jam operasional umum untuk showroom adalah <strong>Senin sampai Sabtu, 08:00 - 17:00/18:00</strong>. Hari Minggu tutup.',
        'contact_intro' => 'Berikut adalah daftar kontak resmi dealer di Dili:',
        'direction_btn' => 'Petunjuk Arah',
        'map_focus_btn' => 'Lihat di Peta',
        'typing' => 'Sedang mengetik...',
        'no_match' => 'Maaf, kami tidak mengerti pertanyaan tersebut. Silakan pilih opsi menu di bawah atau ketik kata kunci seperti "Honda", "Yamaha", "Jam", atau "Kontak".',
        'km_away' => 'km dari Anda'
    ]
];

// Current translations matching language selection
$t = $chat_translations[$chat_lang] ?? $chat_translations['tl'];
?>

<!-- Import Chatbot Stylesheet -->
<link rel="stylesheet" href="assets/css/chatbot.css?v=<?= time() ?>">

<style>
/* ── Flexbox Layout Enforcers ── */
#chatbotCard {
    display: flex !important;
    flex-direction: column !important;
    position: fixed !important;
    bottom: 90px !important;
    right: 20px !important;
    width: 300px !important;
    height: 440px !important;
    max-height: calc(100vh - 110px) !important;
    border-radius: 20px 20px 14px 14px !important;
}
#chatbotCard .chatbot-body {
    flex: 1 1 auto !important;
    min-height: 0 !important;
    overflow-y: auto !important;
}

/* ── Message wide helpers ── */
.chat-message.bot.chat-message-wide,
.chat-message.bot:has(.chatbot-menu-container) {
    max-width: 100% !important;
    width: 100% !important;
}
.chat-message.bot.chat-message-wide .chat-bubble,
.chat-message.bot:has(.chatbot-menu-container) .chat-bubble {
    width: 100% !important;
    padding: 12px 14px !important;
}
.chat-bubble { font-size: 0.8rem !important; }

/* ── Menu buttons ── */
.chatbot-menu-btn {
    padding: 9px 13px !important;
    font-size: 0.78rem !important;
    line-height: 1.3 !important;
    gap: 8px !important;
    width: 100% !important;
}
.chatbot-menu-btn span { flex: 1; white-space: normal !important; word-break: break-word !important; }
.chatbot-menu-btn i    { flex-shrink: 0 !important; }
.chatbot-menu-btn.justify-content-center { text-align: center !important; justify-content: center !important; }
.chatbot-menu-btn.justify-content-center span { flex: none !important; white-space: normal !important; }

/* ════════════════════════════════════════
   MODERN INPUT FOOTER — inline override
   (garante override husi Bootstrap/main)
   ════════════════════════════════════════ */

/* Container */
#chatbotCard .chatbot-input-container {
    flex-shrink: 0 !important;
    padding: 8px 12px 12px !important;
    background: #ffffff !important;
    border-top: 1px solid rgba(0,0,0,0.06) !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 8px !important;
}

/* Hint chips row */
#chatbotCard .chatbot-hints {
    display: flex !important;
    gap: 6px !important;
    flex-wrap: nowrap !important;
    overflow-x: auto !important;
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;
    padding-bottom: 2px !important;
}
#chatbotCard .chatbot-hints::-webkit-scrollbar { display: none !important; }

#chatbotCard .chat-hint-chip {
    display: inline-flex !important;
    align-items: center !important;
    gap: 4px !important;
    background: #f1f5f9 !important;
    border: 1px solid #e2e8f0 !important;
    color: #25285d !important;
    font-size: 0.72rem !important;
    font-weight: 600 !important;
    padding: 4px 10px !important;
    border-radius: 50px !important;
    white-space: nowrap !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    font-family: 'Poppins', sans-serif !important;
    line-height: 1.4 !important;
}
#chatbotCard .chat-hint-chip:hover {
    background: #25285d !important;
    color: #ffffff !important;
    border-color: #25285d !important;
    transform: translateY(-1px) !important;
}

/* Input row wrapper */
#chatbotCard .chatbot-input-row {
    display: flex !important;
    align-items: flex-end !important;
    gap: 10px !important;
    background: #f8fafc !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 18px !important;
    padding: 8px 8px 8px 16px !important;
    transition: border-color 0.25s ease, box-shadow 0.25s ease !important;
    position: relative !important;
}
#chatbotCard .chatbot-input-row:focus-within {
    border-color: #6068d6 !important;
    box-shadow: 0 0 0 3px rgba(96,104,214,0.22) !important;
    background: #ffffff !important;
}

/* Textarea */
#chatbotCard .chatbot-textarea {
    flex: 1 !important;
    border: none !important;
    outline: none !important;
    background: transparent !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 0.86rem !important;
    color: #1e293b !important;
    resize: none !important;
    overflow: hidden !important;
    line-height: 1.5 !important;
    min-height: 26px !important;
    max-height: 110px !important;
    padding: 0 !important;
    margin: 0 !important;
    box-shadow: none !important;
    width: 100% !important;
    display: block !important;
}
#chatbotCard .chatbot-textarea::placeholder { color: #a0aec0 !important; }
#chatbotCard .chatbot-textarea:focus { box-shadow: none !important; border: none !important; outline: none !important; }

/* Action buttons */
#chatbotCard .chatbot-input-actions {
    display: flex !important;
    align-items: center !important;
    gap: 4px !important;
    flex-shrink: 0 !important;
}

#chatbotCard .chat-icon-btn {
    width: 34px !important; height: 34px !important;
    border-radius: 50% !important;
    border: none !important;
    background: transparent !important;
    color: #64748b !important;
    display: flex !important; align-items: center !important; justify-content: center !important;
    cursor: pointer !important;
    font-size: 15px !important;
    transition: all 0.2s ease !important;
    outline: none !important;
    padding: 0 !important;
}
#chatbotCard .chat-icon-btn:hover {
    background: #f1f5f9 !important;
    color: #25285d !important;
    transform: scale(1.08) !important;
}

#chatbotCard .chatbot-send-btn {
    width: 38px !important; height: 38px !important;
    min-width: 38px !important;
    border-radius: 50% !important;
    background: linear-gradient(135deg, #25285d, #6068d6) !important;
    color: #ffffff !important;
    border: none !important;
    outline: none !important;
    cursor: pointer !important;
    display: flex !important; align-items: center !important; justify-content: center !important;
    font-size: 15px !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 12px rgba(37,40,93,0.2) !important;
    flex-shrink: 0 !important;
    padding: 0 !important;
}
#chatbotCard .chatbot-send-btn:hover:not(:disabled) {
    transform: scale(1.08) translateY(-1px) !important;
    box-shadow: 0 6px 18px rgba(37,40,93,0.3) !important;
}
#chatbotCard .chatbot-send-btn:disabled {
    opacity: 0.4 !important;
    cursor: not-allowed !important;
    transform: none !important;
    box-shadow: none !important;
}

/* Char counter */
#chatbotCard .chatbot-char-counter {
    font-size: 0.68rem !important;
    color: #a0aec0 !important;
    text-align: right !important;
    padding-right: 4px !important;
    display: none !important;
}
#chatbotCard .chatbot-char-counter.visible  { display: block !important; }
#chatbotCard .chatbot-char-counter.warning  { color: #f59e0b !important; }
#chatbotCard .chatbot-char-counter.danger   { color: #ef4444 !important; }

/* Emoji panel */
#chatbotCard .chat-emoji-panel {
    position: absolute !important;
    bottom: calc(100% + 6px) !important;
    right: 0 !important;
    width: 272px !important;
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 16px !important;
    box-shadow: 0 12px 32px rgba(0,0,0,0.12) !important;
    padding: 10px !important;
    display: none !important;
    flex-wrap: wrap !important;
    gap: 4px !important;
    z-index: 1200 !important;
    max-height: 170px !important;
    overflow-y: auto !important;
}
#chatbotCard .chat-emoji-panel.open { display: flex !important; }
#chatbotCard .chat-emoji-item {
    font-size: 1.25rem !important;
    padding: 4px !important;
    border-radius: 8px !important;
    cursor: pointer !important;
    transition: background 0.15s !important;
    line-height: 1 !important;
}
#chatbotCard .chat-emoji-item:hover { background: #f1f5f9 !important; }

/* ── Responsive ── */
@media (max-width: 480px) {
    #chatbotCard {
        width: calc(100vw - 24px) !important;
        right: 12px !important;
        left: 12px !important;
        height: calc(100vh - 140px) !important;
        max-height: 380px !important;
        bottom: 75px !important;
        border-radius: 18px !important;
    }
    .chatbot-body { padding: 6px 6px 4px !important; gap: 6px !important; }
    #chatbotCard .chatbot-input-container { padding: 4px 6px 10px !important; }
    #chatbotCard .chat-hint-chip { font-size: 0.58rem !important; padding: 2px 5px !important; }
    .chatbot-menu-btn { padding: 5px 8px !important; font-size: 0.68rem !important; border-radius: 8px !important; }
    .chatbot-result-action { padding: 4px 6px !important; font-size: 0.66rem !important; margin-top: 4px !important; }
    .chat-bubble { font-size: 0.72rem !important; line-height: 1.30 !important; }
    .chatbot-header { padding: 8px 12px !important; }
    .chatbot-avatar { width: 30px !important; height: 30px !important; font-size: 13px !important; }
    .chatbot-header-text h5 { font-size: 0.82rem !important; }
    #chatbotCard .chatbot-textarea { font-size: 0.80rem !important; min-height: 26px !important; }
    #chatbotCard .chatbot-input-row { padding: 5px 5px 5px 10px !important; gap: 5px !important; border-radius: 12px !important; }
    #chatbotCard .chat-icon-btn { width: 26px !important; height: 26px !important; font-size: 12px !important; }
    #chatbotCard .chatbot-send-btn { width: 30px !important; height: 30px !important; min-width: 30px !important; font-size: 11px !important; }
}
@media (max-width: 360px) {
    #chatbotCard {
        width: calc(100vw - 16px) !important;
        right: 8px !important;
        left: 8px !important;
        bottom: 70px !important;
        max-height: 340px !important;
    }
    .chatbot-menu-btn { font-size: 0.64rem !important; padding: 4px 6px !important; }
    #chatbotCard .chat-hint-chip { font-size: 0.55rem !important; padding: 1px 3px !important; }
}
</style>

<!-- Floating Chat Trigger Button -->
<div class="chatbot-trigger" id="chatbotTrigger">
    <div class="chatbot-badge" id="chatbotBadge"></div>
    <i class="fas fa-comments"></i>
    <i class="fas fa-xmark chatbot-close-icon"></i>
</div>

<!-- Chat Widget Card -->
<div class="chatbot-card" id="chatbotCard">
    <!-- Header -->
    <div class="chatbot-header">
        <div class="chatbot-header-info">
            <div class="chatbot-avatar">
                <i class="fas fa-robot text-white"></i>
            </div>
            <div class="chatbot-header-text">
                <h5><?= htmlspecialchars($t['bot_name']) ?></h5>
                <div class="chatbot-status">
                    <span class="chatbot-status-dot"></span>
                    <span><?= htmlspecialchars($t['status']) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Container -->
    <div class="chatbot-body" id="chatbotBody">
        <!-- Initial Greeting Message -->
        <div class="chat-message bot chat-message-wide" style="max-width: 100%; width: 100%;">
            <div class="chat-bubble" style="width: 100%; padding: 12px 14px;">
                <?= htmlspecialchars($t['greeting']) ?>
                
                <!-- Default Quick reply menu buttons -->
                <div class="chatbot-menu-container mt-3" style="width: 100%;">
                    <button class="chatbot-menu-btn" onclick="triggerChatOption('nearest')" style="padding: 8px 12px; font-size: 0.78rem; line-height: 1.3; gap: 8px; width: 100%;">
                        <span style="flex: 1; white-space: normal; word-break: break-word;"><?= htmlspecialchars($t['menu_nearest']) ?></span>
                        <i class="fas fa-location-arrow" style="flex-shrink: 0;"></i>
                    </button>
                    <button class="chatbot-menu-btn" onclick="triggerChatOption('hours')" style="padding: 8px 12px; font-size: 0.78rem; line-height: 1.3; gap: 8px; width: 100%;">
                        <span style="flex: 1; white-space: normal; word-break: break-word;"><?= htmlspecialchars($t['menu_hours']) ?></span>
                        <i class="fas fa-clock" style="flex-shrink: 0;"></i>
                    </button>
                    <button class="chatbot-menu-btn" onclick="triggerChatOption('contact')" style="padding: 8px 12px; font-size: 0.78rem; line-height: 1.3; gap: 8px; width: 100%;">
                        <span style="flex: 1; white-space: normal; word-break: break-word;"><?= htmlspecialchars($t['menu_contact']) ?></span>
                        <i class="fas fa-phone" style="flex-shrink: 0;"></i>
                    </button>
                    <button class="chatbot-menu-btn" onclick="triggerChatOption('brands')" style="padding: 8px 12px; font-size: 0.78rem; line-height: 1.3; gap: 8px; width: 100%;">
                        <span style="flex: 1; white-space: normal; word-break: break-word;"><?= htmlspecialchars($t['menu_brands']) ?></span>
                        <i class="fas fa-motorcycle" style="flex-shrink: 0;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Input Bar — Modern v2 -->
    <div class="chatbot-input-container">

        <!-- Quick-hint chips -->
        <div class="chatbot-hints" id="chatbotHints">
            <button class="chat-hint-chip" data-hint="Honda"><i class="fas fa-motorcycle"></i> Honda</button>
            <button class="chat-hint-chip" data-hint="Yamaha"><i class="fas fa-motorcycle"></i> Yamaha</button>
            <button class="chat-hint-chip" data-hint="oras"><i class="fas fa-clock"></i> Oráriu</button>
            <button class="chat-hint-chip" data-hint="kontaktu"><i class="fas fa-phone"></i> Kontaktu</button>
            <button class="chat-hint-chip" data-hint="besik"><i class="fas fa-location-dot"></i> GPS</button>
        </div>

        <!-- Textarea row -->
        <div class="chatbot-input-row" id="chatbotInputRow" style="position:relative;">
            <textarea
                id="chatbotInput"
                class="chatbot-textarea"
                rows="1"
                placeholder="<?= htmlspecialchars($t['input_placeholder']) ?>"
            ></textarea>

            <div class="chatbot-input-actions">
                <!-- Emoji toggle -->
                <button class="chat-icon-btn" id="chatbotEmojiBtn" title="Emoji" type="button">
                    <i class="far fa-face-smile"></i>
                </button>

                <!-- Send -->
                <button class="chatbot-send-btn" id="chatbotSendBtn" disabled title="Haruka">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>

            <!-- Emoji panel -->
            <div class="chat-emoji-panel" id="chatEmojiPanel">
                <?php
                $emojis = ['😊','👍','🏍️','📍','🔍','📞','🕒','✅','❓','😅','🙏','👋','💬','🗺️','⚡','🔧','💰','🌟','🤝','📱'];
                foreach ($emojis as $e) {
                    echo '<span class="chat-emoji-item">' . $e . '</span>';
                }
                ?>
            </div>
        </div>

        <!-- Character counter -->
        <div class="chatbot-char-counter" id="chatCharCounter">0 / 300</div>
    </div>
</div>

<!-- Localized Translation Dictionary passed to Javascript -->
<script>
    const CHAT_TRANSLATIONS = <?= json_encode($t) ?>;
    const CHAT_LANG = "<?= $chat_lang ?>";
</script>

<!-- Import Chatbot Logic script -->
<script src="assets/js/chatbot.js?v=<?= time() ?>"></script>
