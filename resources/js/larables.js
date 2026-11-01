import Swal from 'sweetalert2';

function Larables() {
    /**
     * Initiate the object.
     * 
     * @return void
     */
    this.init = function () {
        this.registerBulkEvents();
        this.registerPerPageEvents();
        this.registerSearchEvents();
        this.registerCheckboxEvents();
        this.registerSortEvents();
    }

    /**
     * Register the bulk events.
     * 
     * @return void
     */
    this.registerBulkEvents = function () {
        var tableElement = document.querySelector("[larables-id='table']");
        var bulkOptionsElement = document.querySelector("[larables-id='bulk-options-select']");
        var form = document.querySelector("[larables-id='bulk-options-form']");

        if (tableElement == null || bulkOptionsElement == null || form == null) {
            return;
        }

        var checkboxName = tableElement.getAttribute('larables-checkbox-name');

        // Listen for when the bulk options has been selected
        bulkOptionsElement.addEventListener('change', function (event) {
            var element = event.target;
            var checkedValues = [];
            var method = "post";

            // A bulk action must be selected
            if (element.value == '') {
                return Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: 'You did not select a bulk action!',
                });
            }

            // Get all the checked items and add them to the form for submitting
            document.querySelectorAll("[larables-id='checkbox-child']").forEach(function (checkbox) {
                if (checkbox.checked != true) {
                    return;
                }

                // Store the checked value
                checkedValues.push(checkbox.value);

                // Create form input
                var inputElement = document.createElement('input');
                inputElement.setAttribute('type', 'hidden');
                inputElement.setAttribute('name', checkboxName+'[]');
                inputElement.setAttribute('value', checkbox.value);

                // Add to existing form
                form.appendChild(inputElement);
            });

            // If there are no checked items, we reset the bulk option and also
            // let the user know that nothing was selected.
            if (checkedValues.length < 1) {
                element.value = '';
                return Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: 'There is no checked value to submit!',
                });
            }

            // Get the selected option element and get the request type and route
            // so we can fire off the request.
            var option = element.options[element.selectedIndex];
            var requestType = option.getAttribute('request_type').toLowerCase();
            var route = option.getAttribute('route');

            if (requestType == 'get') {
                method = 'get';
            }

            // If request type is not post or patch, we don't need the token field
            if (requestType != 'post' && requestType != 'patch') {
                document.querySelector("[larables-id='bulk-options-csrf-token']").removeAttribute('name');
            }

            // Add the token if request method is post or patch
            if (requestType == 'post' || requestType == 'patch') {
                form.querySelector("[larables-id='bulk-options-csrf-token']").setAttribute('name', '_token');
            }

            // If request type is get or post, we don't need the method spoofing
            if (requestType == 'get' || requestType == 'post') {
                form.querySelector("[larables-id='bulk-options-method']").removeAttribute('name');
            }

            // If request type is not get and post, add method spoofing
            if (requestType != 'get' && requestType != 'post') {
                var methodElement = form.querySelector("[larables-id='bulk-options-method']");
                methodElement.setAttribute('name', '_method');
                methodElement.setAttribute('value', requestType);
            }

            // Set the form method and form action
            form.setAttribute('method', method);
            form.setAttribute('action', route);

            // Set the value of the bulk option selected so that it is included in the request
            form.querySelector("[larables-id='bulk-options-name']").value = element.value;

            // Finally we submit the form
            form.submit();
        });
    }

    /**
     * Register the per page events.
     * 
     * @return void
     */
    this.registerPerPageEvents = function () {
        var perPageElement = document.querySelector("[larables-id='per-page-select']");
        var form = document.querySelector("[larables-id='per-page-form']")

        if (perPageElement == null || form == null) {
            return;
        }

        // Listen for when the per page value changes
        perPageElement.addEventListener('change', function (event) {
            var element = event.target;

            if (element.value == '') {
                return Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: 'Looks like you did not specify the amount of entries you want to be displayed!',
                });
            }

            // Set the per page value selected on the form so it goes with the submitted request
            form.querySelector("[larables-id='per-page-input']").value = element.value;

            form.submit();
        });
    }

    /**
     * Register the search events.
     * 
     * @return void
     */
    this.registerSearchEvents = function () {
        var self = this;
        var searchInput = document.querySelector("[larables-id='search-input']");
        var searchButton = document.querySelector("[larables-id='search-button']");
        var searchForm = document.querySelector("[larables-id='search-form']");

        if (searchInput == null || searchButton == null || searchForm == null) {
            return;
        }

        // Submit form when search is cleared
        searchInput.addEventListener('input', function (event) {
            if (event.target.value.length == 0) {
                return searchForm.submit();
            }
        });

        searchInput.addEventListener('change', function (event) {
            self.handleSearch(searchInput, searchForm);
        });

        searchButton.addEventListener('click', function (event) {
            self.handleSearch(searchInput, searchForm);
        });
    }

    /**
     * Register the checkbox events.
     * 
     * @return void
     */
    this.registerCheckboxEvents = function () {
        document.querySelectorAll("[larables-id='checkbox-parent']").forEach(function (element) {
            element.addEventListener('click', function (event) {
                // We cycle through the body checkboxes and make them the same checked state as the clicked parent checkbox
                document.querySelectorAll("[larables-id='checkbox-child']").forEach(function (checkbox) {
                    checkbox.checked = element.checked;
                });

                // Make all parent checkbox the same checked state as the one that was clicked
                document.querySelectorAll("[larables-id='checkbox-parent']").forEach(function (mainCheckbox) {
                    mainCheckbox.checked = element.checked;
                });
            });
        });
    }

    /**
     * Register the sort events.
     * 
     * @return void
     */
    this.registerSortEvents = function () {
        document.querySelectorAll("[larables-id='column-sort-button']").forEach(function (element) {
            element.addEventListener('click', function (event) {
                element.parentElement.querySelector('form').submit();
            });
        });
    }

    /**
     * Handle the search.
     * 
     * @return void
     */
    this.handleSearch = function (searchInput, form) {
        if (searchInput.value.length < 2) {
            return Swal.fire({
                title: 'Error',
                icon: 'error',
                text: 'Your search query must contain 2 or more characters!',
            });
        }

        var input = document.createElement("input");
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', searchInput.getAttribute('name'));
        input.setAttribute('value', searchInput.value);

        form.appendChild(input);

        return form.submit();
    }
}

new Larables().init();