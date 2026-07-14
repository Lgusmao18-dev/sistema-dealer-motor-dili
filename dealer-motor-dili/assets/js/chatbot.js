/* ============================================================
   Chatbot Premium JS — Dealer Motor Dili (Modern Logic)
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const trigger     = document.getElementById('chatbotTrigger');
    const badge       = document.getElementById('chatbotBadge');
    const card        = document.getElementById('chatbotCard');
    const body        = document.getElementById('chatbotBody');
    const input       = document.getElementById('chatbotInput');   // now a <textarea>
    const sendBtn     = document.getElementById('chatbotSendBtn');
    const emojiBtn    = document.getElementById('chatbotEmojiBtn');
    const emojiPanel  = document.getElementById('chatEmojiPanel');
    const charCounter = document.getElementById('chatCharCounter');
    const hintsRow    = document.getElementById('chatbotHints');

    const MAX_CHARS = 300;

    // ── Auto-resize textarea ──
    function autoResize() {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 110) + 'px';
    }

    function resetTextarea() {
        input.value = '';
        input.style.height = 'auto';
        updateSendState();
        updateCharCounter();
        autoResize();
    }

    function updateSendState() {
        const hasText = input.value.trim().length > 0;
        sendBtn.disabled = !hasText;
    }

    function updateCharCounter() {
        const len = input.value.length;
        charCounter.textContent = len + ' / ' + MAX_CHARS;
        const visible = len > 200;
        charCounter.classList.toggle('visible', visible);
        charCounter.classList.toggle('warning', len > 240);
        charCounter.classList.toggle('danger',  len >= MAX_CHARS);
        if (len >= MAX_CHARS) {
            input.value = input.value.slice(0, MAX_CHARS);
        }
    }

    input.addEventListener('input', () => {
        autoResize();
        updateSendState();
        updateCharCounter();
    });

    // ── Emoji Panel ──
    if (emojiBtn && emojiPanel) {
        emojiBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            emojiPanel.classList.toggle('open');
        });

        emojiPanel.addEventListener('click', (e) => {
            const item = e.target.closest('.chat-emoji-item');
            if (!item) return;
            const cursor = input.selectionStart;
            const before = input.value.slice(0, cursor);
            const after  = input.value.slice(cursor);
            input.value = before + item.textContent + after;
            input.focus();
            autoResize();
            updateSendState();
            updateCharCounter();
            emojiPanel.classList.remove('open');
        });

        document.addEventListener('click', (e) => {
            if (!emojiPanel.contains(e.target) && e.target !== emojiBtn) {
                emojiPanel.classList.remove('open');
            }
        });
    }

    // ── Hint Chips ──
    if (hintsRow) {
        hintsRow.querySelectorAll('.chat-hint-chip').forEach(chip => {
            chip.addEventListener('click', () => {
                const hint = chip.getAttribute('data-hint');
                if (!hint) return;
                input.value = hint;
                autoResize();
                updateSendState();
                input.focus();
                // auto-send after tiny delay for feel
                setTimeout(() => { handleUserMessage(); }, 120);
            });
        });
    }

    let allDealers = [];
    let isFetched = false;

    // Toggle Chat Window
    trigger.addEventListener('click', () => {
        const isOpen = card.classList.toggle('open');
        trigger.classList.toggle('active', isOpen);
        
        // Toggle body class for hiding scroll-to-top button and managing body state
        document.body.classList.toggle('chatbot-open', isOpen);
        
        // Hide notification badge when opened
        if (isOpen) {
            badge.style.display = 'none';
            input.focus();
            autoResize();
            
            // Pre-fetch dealers list for geolocation and brand searches
            if (!isFetched) {
                fetchDealers();
            }
        }
    });

    // Send Button Click
    sendBtn.addEventListener('click', handleUserMessage);

    // Textarea: Enter sends, Shift+Enter inserts newline
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (input.value.trim()) handleUserMessage();
        }
    });

    // Close on escape
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && card.classList.contains('open')) {
            card.classList.remove('open');
            trigger.classList.remove('active');
            document.body.classList.remove('chatbot-open');
        }
    });

    // Fetch Dealer Database from API
    function fetchDealers() {
        fetch('api/get_dealers.php')
            .then(r => r.json())
            .then(data => {
                allDealers = data;
                isFetched = true;
            })
            .catch(err => console.error('Error fetching dealers: ', err));
    }

    // Scroll chat area to bottom
    function scrollToBottom() {
        body.scrollTop = body.scrollHeight;
    }

    // Handle User custom input
    function handleUserMessage() {
        const text = input.value.trim();
        if (!text) return;

        // Append user chat bubble
        appendMessage('user', text);
        resetTextarea();
        scrollToBottom();

        // Show typing indicator
        showTypingIndicator();

        setTimeout(() => {
            removeTypingIndicator();
            respondToKeyword(text);
        }, 1000);
    }

    // Append standard message bubble
    function appendMessage(sender, content, isHtml = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${sender}`;
        
        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble';
        
        if (isHtml) {
            bubble.innerHTML = content;
        } else {
            bubble.textContent = content;
        }
        
        messageDiv.appendChild(bubble);
        body.appendChild(messageDiv);
        scrollToBottom();
        return bubble;
    }

    // Typing Indicator Helpers
    function showTypingIndicator() {
        const indicatorDiv = document.createElement('div');
        indicatorDiv.className = 'chat-message bot temp-typing';
        indicatorDiv.innerHTML = `
            <div class="chat-bubble">
                <div class="typing-indicator">
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                </div>
            </div>
        `;
        body.appendChild(indicatorDiv);
        scrollToBottom();
    }

    function removeTypingIndicator() {
        const el = body.querySelector('.temp-typing');
        if (el) el.remove();
    }

    // Respond based on user text keywords
    function respondToKeyword(text) {
        const q = text.toLowerCase();

        // Check for Nearest GPS trigger
        if (q.includes('besik') || q.includes('gps') || q.includes('nearest') || q.includes('lokasaun') || q.includes('peta') || q.includes('mapa') || q.includes('closest')) {
            triggerNearestDealer();
            return;
        }

        // Check for Working Hours trigger
        if (q.includes('oras') || q.includes('orariu') || q.includes('hours') || q.includes('time') || q.includes('jam') || q.includes('buka') || q.includes('sabadu') || q.includes('segunda')) {
            appendMessage('bot', CHAT_TRANSLATIONS.hours_all, true);
            appendReturnMenu();
            return;
        }

        // Check for Contacts trigger
        if (q.includes('kontaktu') || q.includes('tlf') || q.includes('tel') || q.includes('phone') || q.includes('email') || q.includes('hp')) {
            showOfficialContacts();
            return;
        }

        // Check for Brand triggers
        if (q.includes('honda')) {
            showDealersByBrand('Honda');
            return;
        }
        if (q.includes('yamaha')) {
            showDealersByBrand('Yamaha');
            return;
        }
        if (q.includes('suzuki')) {
            showDealersByBrand('Suzuki');
            return;
        }
        if (q.includes('kawasaki')) {
            showDealersByBrand('Kawasaki');
            return;
        }
        if (q.includes('tvs')) {
            showDealersByBrand('TVS');
            return;
        }
        if (q.includes('marka') || q.includes('brand') || q.includes('motor')) {
            showBrandSelector();
            return;
        }

        // Fallback fallback / no match
        appendMessage('bot', CHAT_TRANSLATIONS.no_match);
        appendReturnMenu();
    }

    // Global option triggers from inline onclick buttons
    window.triggerChatOption = function(option) {
        // Echo user's choice
        let label = '';
        if (option === 'nearest') label = CHAT_TRANSLATIONS.menu_nearest;
        else if (option === 'hours') label = CHAT_TRANSLATIONS.menu_hours;
        else if (option === 'contact') label = CHAT_TRANSLATIONS.menu_contact;
        else if (option === 'brands') label = CHAT_TRANSLATIONS.menu_brands;

        appendMessage('user', label);
        showTypingIndicator();

        setTimeout(() => {
            removeTypingIndicator();
            if (option === 'nearest') triggerNearestDealer();
            else if (option === 'hours') {
                appendMessage('bot', CHAT_TRANSLATIONS.hours_all, true);
                appendReturnMenu();
            }
            else if (option === 'contact') showOfficialContacts();
            else if (option === 'brands') showBrandSelector();
        }, 800);
    };

    // Trigger Nearest Dealer logic using GPS and Haversine formula
    function triggerNearestDealer() {
        if (!navigator.geolocation) {
            appendMessage('bot', CHAT_TRANSLATIONS.gps_unsupported);
            appendReturnMenu();
            return;
        }

        appendMessage('bot', CHAT_TRANSLATIONS.gps_loading);
        showTypingIndicator();

        navigator.geolocation.getCurrentPosition(
            (position) => {
                removeTypingIndicator();
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                if (!isFetched || allDealers.length === 0) {
                    // Fetch if not loaded yet
                    fetch('api/get_dealers.php')
                        .then(r => r.json())
                        .then(data => {
                            allDealers = data;
                            isFetched = true;
                            calculateAndShowNearest(lat, lng);
                        })
                        .catch(() => {
                            appendMessage('bot', 'Error loading dealers.');
                            appendReturnMenu();
                        });
                } else {
                    calculateAndShowNearest(lat, lng);
                }
            },
            (error) => {
                removeTypingIndicator();
                appendMessage('bot', CHAT_TRANSLATIONS.gps_denied);
                appendReturnMenu();
            },
            { enableHighAccuracy: true, timeout: 8000 }
        );
    }

    // Distance Calculation (Haversine formula in km)
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Earth radius in km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    // Sort and present nearest dealer
    function calculateAndShowNearest(userLat, userLng) {
        if (allDealers.length === 0) {
            appendMessage('bot', 'No dealers found in database.');
            appendReturnMenu();
            return;
        }

        // Clone and map distance
        const sorted = allDealers.map(d => {
            const dist = getDistance(userLat, userLng, d.latitude, d.longitude);
            return { ...d, distance: dist };
        }).sort((a, b) => a.distance - b.distance);

        const nearest = sorted[0];
        
        appendMessage('bot', CHAT_TRANSLATIONS.gps_nearest_res + ` (<strong>${nearest.distance.toFixed(2)} ${CHAT_TRANSLATIONS.km_away}</strong>):`, true);
        
        // Present details inside card
        presentDealerCard(nearest);
        appendReturnMenu();
    }

    // Brand Selection Menu
    function showBrandSelector() {
        const wrapper = appendMessage('bot', CHAT_TRANSLATIONS.brand_prompt);
        wrapper.parentElement.classList.add('chat-message-wide');
        wrapper.parentElement.setAttribute('style', 'max-width: 100%; width: 100%;');
        wrapper.setAttribute('style', 'width: 100%; padding: 12px 14px;');
        
        const menuContainer = document.createElement('div');
        menuContainer.className = 'chatbot-menu-container mt-2';
        menuContainer.setAttribute('style', 'width: 100%;');

        const brands = ['Honda', 'Yamaha', 'Suzuki', 'Kawasaki', 'TVS'];
        brands.forEach(b => {
            const btn = document.createElement('button');
            btn.className = 'chatbot-menu-btn';
            btn.setAttribute('style', 'padding: 8px 12px; font-size: 0.78rem; line-height: 1.3; gap: 8px; width: 100%;');
            btn.innerHTML = `<span style="flex: 1; white-space: normal; word-break: break-word;">🏍️ ${b}</span> <i class="fas fa-chevron-right" style="flex-shrink: 0;"></i>`;
            btn.addEventListener('click', () => {
                appendMessage('user', b);
                showTypingIndicator();
                setTimeout(() => {
                    removeTypingIndicator();
                    showDealersByBrand(b);
                }, 600);
            });
            menuContainer.appendChild(btn);
        });

        wrapper.appendChild(menuContainer);
    }

    // Show Dealers filtering by brand
    function showDealersByBrand(brand) {
        const filtered = allDealers.filter(d => (d.marka || '').toLowerCase() === brand.toLowerCase());
        
        if (filtered.length === 0) {
            appendMessage('bot', `Deskulpa, ami la hetan dealer ba marka ${brand}.`);
            appendReturnMenu();
            return;
        }

        filtered.forEach(d => {
            presentDealerCard(d);
        });
        
        appendReturnMenu();
    }

    // Show all Official Contacts in list
    function showOfficialContacts() {
        let content = `<p>${CHAT_TRANSLATIONS.contact_intro}</p><ul class="p-0 ps-3 mb-0" style="list-style-type: none;">`;
        allDealers.forEach(d => {
            if (d.telepon) {
                content += `<li class="mb-2"><strong>${d.nama_dealer}</strong>:<br><a href="tel:${d.telepon}" class="text-decoration-none text-primary fw-bold"><i class="fas fa-phone me-1"></i>${d.telepon}</a></li>`;
            }
        });
        content += '</ul>';
        appendMessage('bot', content, true);
        appendReturnMenu();
    }

    // Renders a beautiful visual card for a dealer with interaction triggers
    function presentDealerCard(d) {
        // Determine image source based on dealer details or brands
        let imgSrc = 'assets/images/deller.png';
        if (d.foto) {
            imgSrc = 'assets/images/dealers/' + d.foto;
        } else {
            const brand = (d.marka || '').toLowerCase().trim();
            if (brand === 'honda') imgSrc = 'assets/images/honda_motorcycle_1778566690777.png';
            else if (brand === 'yamaha') imgSrc = 'assets/images/yamaha_motorcycle_1778566896989.png';
            else if (brand === 'suzuki') imgSrc = 'assets/images/suzuki_motorcycle_1778566930123.png';
            else if (brand === 'kawasaki') imgSrc = 'assets/images/kawasaki_motorcycle_1778567013613.png';
            else if (brand === 'tvs') imgSrc = 'assets/images/tvs_motorcycle_1778567095794.png';
        }

        const formattedPrice = new Intl.NumberFormat().format(d.presu);

        const cardHtml = `
            <div class="chatbot-result-card">
                <img src="${imgSrc}" class="chatbot-result-img" alt="${d.nama_dealer}">
                <div class="chatbot-result-title">${d.nama_dealer}</div>
                <div class="chatbot-result-badge"><i class="fas fa-motorcycle me-1"></i>${d.marka.toUpperCase()}</div>
                
                <div class="mt-2">
                    <div class="chatbot-result-detail">
                        <i class="fas fa-location-dot"></i>
                        <span>${d.alamat}</span>
                    </div>
                    <div class="chatbot-result-detail">
                        <i class="fas fa-clock"></i>
                        <span>${d.jam_buka}</span>
                    </div>
                    ${d.telepon ? `
                    <div class="chatbot-result-detail">
                        <i class="fas fa-phone"></i>
                        <a href="tel:${d.telepon}" class="text-decoration-none text-secondary">${d.telepon}</a>
                    </div>` : ''}
                    <div class="chatbot-result-detail fw-bold text-dark mt-1">
                        <span>Média Presu: $ ${formattedPrice}</span>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-2">
                    <button class="chatbot-result-action py-1.5 px-2 flex-grow-1" onclick="focusDealerOnMap(${d.id}, ${d.latitude}, ${d.longitude})">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>${CHAT_TRANSLATIONS.map_focus_btn}</span>
                    </button>
                    <a href="https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(d.nama_dealer + ' Dili')}"
                       target="_blank"
                       class="chatbot-result-action py-1.5 px-2 flex-grow-1 text-center">
                        <i class="fas fa-route"></i>
                        <span>${CHAT_TRANSLATIONS.direction_btn}</span>
                    </a>
                </div>
            </div>
        `;
        
        appendMessage('bot', cardHtml, true);
    }

    // Dynamic Leaflet Map Interaction Function
    window.focusDealerOnMap = function(dealerId, lat, lng) {
        // Close Chatbot Window
        card.classList.remove('open');
        trigger.classList.remove('active');
        document.body.classList.remove('chatbot-open');

        // Check if map and Leaflet are available on the page
        if (typeof map !== 'undefined' && typeof allMarkers !== 'undefined') {
            // Scroll to the map section smoothly
            const mapSection = document.getElementById('map-section');
            if (mapSection) {
                mapSection.scrollIntoView({ behavior: 'smooth' });
            }

            // Trigger the view modification with zoom focus
            setTimeout(() => {
                map.setView([lat, lng], 17);
                
                // Find and open popup marker
                const targetMarker = allMarkers.find(m => m.dealerId === parseInt(dealerId));
                if (targetMarker) {
                    targetMarker.openPopup();
                }
            }, 600);
        } else {
            // Fallback if not on Home Page (redirect to index.php with query parameter)
            window.location.href = `index.php?focus=${dealerId}#map-section`;
        }
    };

    // Handle home-page focus parameters on page load
    const urlParams = new URLSearchParams(window.location.search);
    const focusId = urlParams.get('focus');
    if (focusId && typeof map !== 'undefined' && typeof allMarkers !== 'undefined') {
        // Wait for marker registration
        setTimeout(() => {
            const targetMarker = allMarkers.find(m => m.dealerId === parseInt(focusId));
            if (targetMarker) {
                map.setView(targetMarker.getLatLng(), 17);
                targetMarker.openPopup();
            }
        }, 1200);
    }

    // Appends a button to go back to main options
    function appendReturnMenu() {
        const container = document.createElement('div');
        container.className = 'chatbot-menu-container mt-3';
        
        const returnBtn = document.createElement('button');
        returnBtn.className = 'chatbot-menu-btn btn-sm border-dashed w-100 justify-content-center text-secondary';
        returnBtn.innerHTML = `<span><i class="fas fa-circle-left me-1"></i> Fila ba Menu Prinsipál</span>`;
        returnBtn.addEventListener('click', () => {
            appendMessage('user', 'Fila ba Menu');
            showTypingIndicator();
            setTimeout(() => {
                removeTypingIndicator();
                const welcomeMsg = appendMessage('bot', CHAT_TRANSLATIONS.greeting);
                welcomeMsg.parentElement.classList.add('chat-message-wide');
                welcomeMsg.parentElement.setAttribute('style', 'max-width: 100%; width: 100%;');
                welcomeMsg.setAttribute('style', 'width: 100%; padding: 12px 14px;');
                
                const optContainer = document.createElement('div');
                optContainer.className = 'chatbot-menu-container mt-3';
                optContainer.setAttribute('style', 'width: 100%;');
                optContainer.innerHTML = `
                    <button class="chatbot-menu-btn" onclick="triggerChatOption('nearest')" style="padding: 8px 12px; font-size: 0.78rem; line-height: 1.3; gap: 8px; width: 100%;">
                        <span style="flex: 1; white-space: normal; word-break: break-word;">${CHAT_TRANSLATIONS.menu_nearest}</span>
                        <i class="fas fa-location-arrow" style="flex-shrink: 0;"></i>
                    </button>
                    <button class="chatbot-menu-btn" onclick="triggerChatOption('hours')" style="padding: 8px 12px; font-size: 0.78rem; line-height: 1.3; gap: 8px; width: 100%;">
                        <span style="flex: 1; white-space: normal; word-break: break-word;">${CHAT_TRANSLATIONS.menu_hours}</span>
                        <i class="fas fa-clock" style="flex-shrink: 0;"></i>
                    </button>
                    <button class="chatbot-menu-btn" onclick="triggerChatOption('contact')" style="padding: 8px 12px; font-size: 0.78rem; line-height: 1.3; gap: 8px; width: 100%;">
                        <span style="flex: 1; white-space: normal; word-break: break-word;">${CHAT_TRANSLATIONS.menu_contact}</span>
                        <i class="fas fa-phone" style="flex-shrink: 0;"></i>
                    </button>
                    <button class="chatbot-menu-btn" onclick="triggerChatOption('brands')" style="padding: 8px 12px; font-size: 0.78rem; line-height: 1.3; gap: 8px; width: 100%;">
                        <span style="flex: 1; white-space: normal; word-break: break-word;">${CHAT_TRANSLATIONS.menu_brands}</span>
                        <i class="fas fa-motorcycle" style="flex-shrink: 0;"></i>
                    </button>
                `;
                welcomeMsg.appendChild(optContainer);
            }, 600);
        });

        container.appendChild(returnBtn);
        body.appendChild(container);
        scrollToBottom();
    }
});
