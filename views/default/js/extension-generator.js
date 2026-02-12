/**
 * Extension Generator - Vanilla JS Utilities
 * Bootstrap 5 / Paradigm Theme Compatible
 */
(function() {
    'use strict';

    var ExtensionGenerator = {
        /**
         * Initialize all dynamic row handlers
         */
        init: function() {
            this.initTooltips();
            this.initDynamicRows();
            this.initTypeSelection();
            this.initLocationToggle();
            this.initDatabaseTable();
            this.initEncryptableCheckboxes();
            this.initNameKeyRadios();
            this.initColumnTypeHandlers();
            this.initInfoToggles();
            this.initModuleTypeToggle();
            this.initStaticTldsToggle();
            this.initTypeWarning();
        },

        /**
         * Initialize Bootstrap tooltips
         */
        initTooltips: function() {
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
                    new bootstrap.Tooltip(el);
                });
            }
        },

        /**
         * Generic dynamic row handler using templates
         * @param {string} containerSelector - Container element selector
         * @param {string} templateId - Template element ID
         * @param {string} addBtnSelector - Add button selector
         * @param {string} removeBtnSelector - Remove button selector
         * @param {number} minRows - Minimum rows to keep (default 0)
         * @param {function} onAdd - Callback after adding row
         * @param {function} onRemove - Callback after removing row
         */
        initDynamicRowHandler: function(options) {
            var container = document.querySelector(options.containerSelector);
            var template = document.getElementById(options.templateId);
            var addBtn = document.querySelector(options.addBtnSelector);

            if (!container || !addBtn) return;

            var rowCounter = container.querySelectorAll(options.rowSelector || 'tr').length;
            var minRows = options.minRows || 0;

            // Add row handler
            addBtn.addEventListener('click', function(e) {
                e.preventDefault();

                var newRow;
                if (template) {
                    newRow = template.content.cloneNode(true).firstElementChild;
                } else if (options.cloneSelector) {
                    var source = container.querySelector(options.cloneSelector);
                    if (!source) return;
                    newRow = source.cloneNode(true);
                    newRow.style.display = '';
                    // Enable any disabled fields
                    newRow.querySelectorAll('[disabled]').forEach(function(el) {
                        el.removeAttribute('disabled');
                    });
                    // Clear values
                    newRow.querySelectorAll('input[type="text"], textarea').forEach(function(el) {
                        el.value = '';
                    });
                    newRow.querySelectorAll('select').forEach(function(el) {
                        el.selectedIndex = 0;
                    });
                    newRow.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(function(el) {
                        el.checked = false;
                    });
                }

                if (!newRow) return;

                // Update field names with new index if needed
                if (options.indexedFields) {
                    newRow.querySelectorAll('[name]').forEach(function(el) {
                        el.name = el.name.replace(/\[\d*\]/, '[' + rowCounter + ']');
                    });
                }

                container.appendChild(newRow);
                rowCounter++;

                if (options.onAdd) {
                    options.onAdd(newRow);
                }
            });

            // Remove row handler using event delegation
            container.addEventListener('click', function(e) {
                var removeBtn = e.target.closest(options.removeBtnSelector);
                if (!removeBtn) return;

                e.preventDefault();
                var row = removeBtn.closest(options.rowSelector || 'tr');
                var rows = container.querySelectorAll(options.rowSelector || 'tr');

                // Check if visible rows > minRows
                var visibleRows = Array.from(rows).filter(function(r) {
                    return r.style.display !== 'none';
                });

                if (visibleRows.length > minRows && row) {
                    row.remove();
                    if (options.onRemove) {
                        options.onRemove();
                    }
                }
            });
        },

        /**
         * Initialize all dynamic row sections
         */
        initDynamicRows: function() {
            var self = this;

            // Author rows (module, plugin, merchant, nonmerchant basic pages)
            this.initDynamicRowHandler({
                containerSelector: '#authors-table tbody',
                addBtnSelector: '.author-row-add',
                removeBtnSelector: '.remove-row',
                cloneSelector: 'tr.author-row',
                rowSelector: 'tr.author-row',
                minRows: 1
            });

            // Module row fields
            this.initDynamicRowHandler({
                containerSelector: '#module-rows-table tbody',
                addBtnSelector: '.module-row-add',
                removeBtnSelector: '.remove-row',
                cloneSelector: 'tr.module-row:first-child',
                rowSelector: 'tr.module-row',
                minRows: 1,
                onRemove: function() {
                    self.ensureNameKeySelected('module');
                }
            });

            // Package fields
            this.initDynamicRowHandler({
                containerSelector: '#package-fields-table tbody',
                addBtnSelector: '.package-row-add',
                removeBtnSelector: '.remove-row',
                cloneSelector: 'tr.package-row:first-child',
                rowSelector: 'tr.package-row',
                minRows: 0
            });

            // Service fields
            this.initDynamicRowHandler({
                containerSelector: '#service-fields-table tbody',
                addBtnSelector: '.service-row-add',
                removeBtnSelector: '.remove-row',
                cloneSelector: 'tr.service-row:first-child',
                rowSelector: 'tr.service-row',
                minRows: 0
            });

            // Service tabs (module and plugin features)
            this.initDynamicRowHandler({
                containerSelector: '#service-tabs-table tbody',
                addBtnSelector: '.service-tab-row-add',
                removeBtnSelector: '.remove-row',
                cloneSelector: 'tr.service-tab-row:first-child',
                rowSelector: 'tr.service-tab-row',
                minRows: 0
            });

            // Cron tasks
            this.initDynamicRowHandler({
                containerSelector: '#cron-tasks-table tbody',
                addBtnSelector: '.cron-task-row-add',
                removeBtnSelector: '.remove-row',
                cloneSelector: 'tr.cron-task-row:first-child',
                rowSelector: 'tr.cron-task-row',
                minRows: 0
            });

            // Gateway fields
            this.initDynamicRowHandler({
                containerSelector: '#fields-table tbody',
                addBtnSelector: '.field-row-add',
                removeBtnSelector: '.remove-row',
                cloneSelector: 'tr.field-row:first-child',
                rowSelector: 'tr.field-row',
                minRows: 0
            });

            // Plugin actions
            this.initDynamicRowHandler({
                containerSelector: '#actions-table tbody',
                addBtnSelector: '.action-row-add',
                removeBtnSelector: '.remove-row',
                cloneSelector: 'tr.action-row:first-child',
                rowSelector: 'tr.action-row',
                minRows: 0
            });

            // Plugin events
            this.initDynamicRowHandler({
                containerSelector: '#events-table tbody',
                addBtnSelector: '.event-row-add',
                removeBtnSelector: '.remove-row',
                cloneSelector: 'tr.event-row:first-child',
                rowSelector: 'tr.event-row',
                minRows: 0
            });

            // Plugin cards
            this.initDynamicRowHandler({
                containerSelector: '#cards-table tbody',
                addBtnSelector: '.card-row-add',
                removeBtnSelector: '.remove-row',
                cloneSelector: 'tr.card-row:first-child',
                rowSelector: 'tr.card-row',
                minRows: 0
            });
        },

        /**
         * Initialize extension type card selection
         */
        initTypeSelection: function() {
            var cards = document.querySelectorAll('.extension-type-card');
            var hiddenInput = document.getElementById('extension-type-input');

            if (!cards.length || !hiddenInput) return;

            cards.forEach(function(card) {
                card.addEventListener('click', function() {
                    // Remove active from all cards
                    cards.forEach(function(c) {
                        c.classList.remove('active');
                    });
                    // Add active to clicked card
                    card.classList.add('active');
                    // Update hidden input
                    hiddenInput.value = card.dataset.type;
                });
            });
        },

        /**
         * Initialize location toggle for custom path
         */
        initLocationToggle: function() {
            var locationSelect = document.getElementById('location');
            var customPathSection = document.getElementById('custom-path-section');

            if (!locationSelect || !customPathSection) return;

            function toggleCustomPath() {
                if (locationSelect.value === 'custom') {
                    customPathSection.classList.remove('d-none');
                } else {
                    customPathSection.classList.add('d-none');
                }
            }

            locationSelect.addEventListener('change', toggleCustomPath);
            toggleCustomPath();
        },

        /**
         * Initialize database table management for plugins
         */
        initDatabaseTable: function() {
            var container = document.getElementById('database-tables');
            var addTableBtn = document.querySelector('.table-row-add');

            if (!container || !addTableBtn) return;

            var self = this;
            var tableCounter = container.querySelectorAll('.table-section').length;

            // Add table handler
            addTableBtn.addEventListener('click', function(e) {
                e.preventDefault();

                var template = container.querySelector('.table-section[data-table="-1"]');
                if (!template) return;

                var newTable = template.cloneNode(true);
                newTable.style.display = '';
                tableCounter++;

                // Update data attribute
                newTable.dataset.table = tableCounter;

                // Update field names
                var html = newTable.innerHTML;
                html = html.replace(/-1/g, tableCounter);
                newTable.innerHTML = html;

                // Enable fields
                newTable.querySelectorAll('[disabled]').forEach(function(el) {
                    el.removeAttribute('disabled');
                });

                container.appendChild(newTable);

                // Initialize tooltips if available
                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    newTable.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
                        new bootstrap.Tooltip(el);
                    });
                }
            });

            // Event delegation for dynamic elements
            container.addEventListener('click', function(e) {
                // Remove table
                if (e.target.closest('.table-row-remove')) {
                    e.preventDefault();
                    var tableSection = e.target.closest('.table-section');
                    if (tableSection) {
                        tableSection.remove();
                    }
                    return;
                }

                // Add column
                if (e.target.closest('.column-row-add')) {
                    e.preventDefault();
                    var tableSection = e.target.closest('.table-section');
                    var tbody = tableSection.querySelector('tbody');
                    var lastRow = tbody.querySelector('tr.column-row:last-child');

                    if (!lastRow) return;

                    var newRow = lastRow.cloneNode(true);
                    var colNum = parseInt(lastRow.dataset.column || 0) + 1;
                    newRow.dataset.column = colNum;

                    // Update field names
                    var html = newRow.innerHTML;
                    var tableNum = tableSection.dataset.table;
                    html = html.replace(new RegExp('c' + (colNum - 1), 'g'), 'c' + colNum);
                    newRow.innerHTML = html;

                    // Clear values and enable fields
                    newRow.querySelectorAll('input[type="text"], textarea').forEach(function(el) {
                        el.value = '';
                        el.removeAttribute('disabled');
                    });
                    newRow.querySelectorAll('select').forEach(function(el) {
                        el.selectedIndex = 0;
                        el.removeAttribute('disabled');
                    });
                    newRow.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(function(el) {
                        el.checked = false;
                        el.removeAttribute('disabled');
                    });

                    tbody.appendChild(newRow);
                    return;
                }

                // Remove column
                if (e.target.closest('.column-row-remove')) {
                    e.preventDefault();
                    var tbody = e.target.closest('tbody');
                    var rows = tbody.querySelectorAll('tr.column-row');

                    if (rows.length > 1) {
                        e.target.closest('tr').remove();

                        // Ensure primary key is selected
                        var checkedPrimary = tbody.querySelector('.primary-key:checked');
                        if (!checkedPrimary) {
                            var lastPrimary = tbody.querySelector('tr:last-child .primary-key');
                            if (lastPrimary) {
                                lastPrimary.checked = true;
                            }
                        }
                    }
                    return;
                }

                // Primary key selection
                if (e.target.closest('.primary-key')) {
                    var tbody = e.target.closest('tbody');
                    tbody.querySelectorAll('.primary-key').forEach(function(el) {
                        el.checked = false;
                    });
                    e.target.checked = true;
                }
            });
        },

        /**
         * Initialize encryptable checkbox handlers
         */
        initEncryptableCheckboxes: function() {
            document.addEventListener('change', function(e) {
                if (!e.target.classList.contains('encryptable-checkbox')) return;

                var hiddenInput = e.target.closest('td').querySelector('.encryptable-value');
                if (hiddenInput) {
                    hiddenInput.value = e.target.checked ? 'true' : 'false';
                }
            });
        },

        /**
         * Initialize name key radio handlers
         */
        initNameKeyRadios: function() {
            document.addEventListener('click', function(e) {
                if (!e.target.classList.contains('name-key-radio')) return;

                var table = e.target.closest('table');
                var fieldType = e.target.dataset.fieldType;

                // Update all hidden inputs in this table
                table.querySelectorAll('.name-key-value').forEach(function(el) {
                    el.value = 'false';
                });

                // Set clicked one to true
                var hiddenInput = e.target.closest('td').querySelector('.name-key-value');
                if (hiddenInput) {
                    hiddenInput.value = 'true';
                }
            });
        },

        /**
         * Ensure at least one name key is selected
         * @param {string} fieldType - Type of field (module, package, service)
         */
        ensureNameKeySelected: function(fieldType) {
            var table = document.getElementById(fieldType + '-rows-table');
            if (!table) return;

            var checkedRadio = table.querySelector('.name-key-radio:checked');
            if (!checkedRadio) {
                var lastRadio = table.querySelector('tbody tr:last-child .name-key-radio');
                if (lastRadio) {
                    lastRadio.checked = true;
                    var hiddenInput = lastRadio.closest('td').querySelector('.name-key-value');
                    if (hiddenInput) {
                        hiddenInput.value = 'true';
                    }
                }
            }
        },

        /**
         * Initialize column type change handlers for database tables
         */
        initColumnTypeHandlers: function() {
            var defaultLengths = {
                'INT': 10,
                'TINYINT': 1,
                'VARCHAR': 64,
                'DATETIME': '',
                'TEXT': '',
                'ENUM': "'a','b','c'"
            };
            var noLengthTypes = ['DATETIME', 'TEXT'];

            document.addEventListener('change', function(e) {
                if (!e.target.classList.contains('column-type-select')) return;

                var row = e.target.closest('tr');
                var lengthInput = row.querySelector('.column-length');
                var primaryInput = row.querySelector('.primary-key');
                var type = e.target.value;

                if (lengthInput) {
                    lengthInput.value = defaultLengths[type] || '';
                    lengthInput.disabled = noLengthTypes.indexOf(type) !== -1;
                }

                if (primaryInput) {
                    primaryInput.disabled = noLengthTypes.indexOf(type) !== -1;
                }
            });
        },

        /**
         * Initialize info section toggles
         */
        initInfoToggles: function() {
            document.querySelectorAll('[data-toggle-info]').forEach(function(trigger) {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    var targetId = trigger.dataset.toggleInfo;
                    var target = document.getElementById(targetId);
                    if (target) {
                        target.classList.toggle('d-none');
                    }
                });
            });
        },

        /**
         * Initialize module type toggle for TLDs section
         */
        initModuleTypeToggle: function() {
            var moduleTypeSelect = document.getElementById('module_type');
            var tldsSection = document.getElementById('static-tlds-section');

            if (!moduleTypeSelect || !tldsSection) return;

            function toggleTldsSection() {
                if (moduleTypeSelect.value === 'registrar') {
                    tldsSection.classList.remove('d-none');
                } else {
                    tldsSection.classList.add('d-none');
                }
            }

            moduleTypeSelect.addEventListener('change', toggleTldsSection);
            toggleTldsSection();
        },

        /**
         * Initialize static TLDs checkbox toggle
         */
        initStaticTldsToggle: function() {
            var staticTldsCheckbox = document.getElementById('static_tlds');
            var tldsFields = document.getElementById('static-tlds-fields');

            if (!staticTldsCheckbox || !tldsFields) return;

            function toggleTldsFields() {
                if (staticTldsCheckbox.checked) {
                    tldsFields.classList.remove('d-none');
                } else {
                    tldsFields.classList.add('d-none');
                }
            }

            staticTldsCheckbox.addEventListener('change', toggleTldsFields);
            toggleTldsFields();
        },

        /**
         * Initialize type change warning
         */
        initTypeWarning: function() {
            var typeCards = document.querySelectorAll('.extension-type-card');
            var typeWarning = document.getElementById('type-warning');
            var originalType = document.getElementById('original-type');

            if (!typeCards.length || !typeWarning || !originalType) return;

            typeCards.forEach(function(card) {
                card.addEventListener('click', function() {
                    var currentType = card.dataset.type;
                    var savedType = originalType.value;

                    if (savedType && currentType !== savedType) {
                        typeWarning.classList.remove('d-none');
                    } else {
                        typeWarning.classList.add('d-none');
                    }
                });
            });
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            ExtensionGenerator.init();
        });
    } else {
        ExtensionGenerator.init();
    }

    // Expose globally if needed
    window.ExtensionGenerator = ExtensionGenerator;
})();
