@extends('layouts.dashboard')

@section('CSS')
<!-- Add this to your CSS -->
<style>
    /* Apply to all table cells */
    .includes div.d-flex.flex-column {
        display: flex;
        flex-direction: column;
    }

    .includes div.d-flex.justify-content-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px; /* Add space between labels and values */
    }

    .includes div.d-flex.justify-content-between h6.label {
        width: 70px; /* Fixed width to align the labels in a column */
        margin: 0;
        font-weight: 600;
        text-align: left; /* Ensure text aligns to the left */
    }

    .includes div.d-flex.justify-content-between h6.value {
        margin: 0;
        font-weight: 400;
        text-align: right; /* Ensure values align to the right */
    }

    .includes div.d-flex.flex-column h6 {
        margin-bottom: 4px; /* Add consistent spacing between rows */
    }

    .modal {
        display: none; /* Hidden by default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .modal-content {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 450px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .modal-buttons {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-top: 20px;
    }
    .btn-confirm {
        background: #f44336;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-cancel {
        background: #ccc;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-confirm:hover {
        background: #d32f2f;
    }
    .btn-cancel:hover {
        background: #b0b0b0;
    }
    .loader {
        border: 4px solid #f3f3f3; /* Light grey */
        border-top: 4px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 24px;
        height: 24px;
        animation: spin 2s linear infinite;
    }
    #yearFilter, #monthFilter {
        min-width: 150px;
    }
    @keyframes spin {
        0% {
        transform: rotate(0deg);
        }
        100% {
        transform: rotate(360deg);
        }
    }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border shadow-xs mb-4">
            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Confirmed Deals list</h6>
                        <p class="text-sm">See information about all Deals</p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 py-0">
                <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                    <div class="py-3 px-3 d-sm-flex align-items-center">
                        <!-- Date Filtration -->
                        <select id="yearFilter" class="form-select" style="width: 150px;">
                            <option value="" selected>Year</option>
                            <!-- Populate with years dynamically -->
                        </select>

                        <select id="monthFilter" class="mx-2 form-select" style="width: 150px;">
                            <option value="" selected>Month</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>

                        <button id="filterByDate" class="btn btn-primary mx-2 mb-0">Filter</button>
                        <button id="resetFilters" class="btn btn-secondary mr-2 mb-0">Reset</button>
                    </div>

                    <div class="input-group w-sm-25 ms-auto">
                        <span class="input-group-text text-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                        </svg>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search">
                    </div>
                </div>
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="DealsTable">
                        <thead class="bg-gray-100">
                            <tr style="text-align: center;">
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">User</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Company</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Package</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">From / To</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Number of Guests</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Total Paid Price</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deals as $key => $deal)
                            <tr data-status="@if($deal->reservation_type == 1){{'basic'}}@elseif($deal->reservation_type == 2){{'half_board'}}@elseif($deal->reservation_type == 3){{'full_course'}}@endif" data-company-id="{{ $deal->id }}" id="row-{{$deal->id}}">
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex align-items-center">
                                            <img src="../assets/img/team-5.jpg" class="avatar avatar-sm rounded-circle me-2" alt="user5">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center ms-1">
                                            <h6 class="mb-0 text-sm font-weight-semibold">{{ $deal->User->name }}</h6>
                                            <p class="text-sm text-secondary mb-0">{{ $deal->User->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex align-items-center">
                                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm rounded-circle me-2" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center ms-1">
                                            <h6 class="mb-0 text-sm font-weight-semibold">{{ $deal->Package->Company->name }}</h6>
                                            <p class="text-sm text-secondary mb-0">{{ $deal->Package->Company->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center ms-1">
                                            <h6 class="mb-0 text-sm font-weight-semibold">{{ $deal->Package->name }}</h6>
                                            <p class="text-sm text-secondary mb-0">{{ $deal->Package->name_ar }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center ms-1">
                                            <h6 class="mb-0 text-sm font-weight-semibold">From: {{ $deal->due_date }}</h6>
                                            <h6 class="mb-0 text-sm font-weight-semibold">To  : {{ $deal->end_date }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <p class="text-sm text-dark font-weight-semibold mb-0">{{ $deal->no_of_guests }}</p>
                                </td>
                                <td>
                                    <p class="text-sm text-dark text-center font-weight-semibold mb-0">{{ ($deal->no_of_guests * $deal->Package->price_per_person) }}</p>
                                </td>
                                <td class="align-middle text-center" data-date="{{ $deal->created_at->toDateString() }}">
                                    <span class="text-secondary text-sm font-weight-normal">{{ $deal->created_at->toDateString() }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="border-top py-3 px-3 d-flex align-items-center">
                    <p class="font-weight-semibold mb-0 text-dark text-sm paging"></p>
                    <div class="ms-auto">
                        <button class="btn btn-sm btn-white mb-0 previous">Previous</button>
                        <button class="btn btn-sm btn-white mb-0 next">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('JavaScript')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput      = document.getElementById("searchInput");
        const table            = document.getElementById("DealsTable");
        const tableRows        = Array.from(table.querySelectorAll("tbody tr"));
    
        const yearFilter       = document.getElementById("yearFilter");
        const monthFilter      = document.getElementById("monthFilter");
        const filterButton     = document.getElementById("filterByDate");
    
        const pageInfo         = document.querySelector(".paging");
        const prevButton       = document.querySelector(".previous");
        const nextButton       = document.querySelector(".next");

        let filteredRows  = [...tableRows]; // Rows currently visible (filtered or searched)
        let currentPage   = 1;
        const rowsPerPage = 10;

        // Populate year dropdown based on available data
        const populateYears = () => {
            const years = new Set();
            tableRows.forEach(row => {
                const dateCell = row.querySelector("td[data-date]");
                if (dateCell) {
                    const year = dateCell.getAttribute("data-date").slice(0, 4); // Extract year from "YYYY-MM-DD"
                    years.add(year);
                }
            });

            // Sort years in descending order
            Array.from(years).sort((a, b) => b - a).forEach(year => {
                const option = document.createElement("option");
                option.value = year;
                option.textContent = year;
                yearFilter.appendChild(option);
            });
        };

        // Function to update the table display based on the current page
        const updateTable = () => {
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = currentPage * rowsPerPage;

            tableRows.forEach(row => (row.style.display = "none")); // Hide all rows
            filteredRows.slice(startIndex, endIndex).forEach(row => (row.style.display = "")); // Show only rows for the current page

            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
            prevButton.disabled = currentPage === 1;
            nextButton.disabled = currentPage === totalPages || totalPages === 0;
        };

        // Search table within the current filtered rows
        const searchTable = () => {
            const query = searchInput.value.toLowerCase().trim();
            filteredRows = tableRows.filter(row => {
                const CompanyName   = row.cells[1].textContent.toLowerCase();
                const matchesSearch = CompanyName.includes(query);

                return matchesSearch; // matchesFilter &&;
            });

            currentPage = 1;
            updateTable();
        };

        // Filter table by date
        const filterTableByDate = (year, month) => {
            const formattedDate = `${year}-${month}`;
            filteredRows = filteredRows.filter(row => {
                const dateCell = row.querySelector("td[data-date]");
                if (dateCell) {
                    const cellDate = dateCell.getAttribute("data-date").slice(0, 7); // Get "YYYY-MM"
                    return cellDate === formattedDate;
                }
                return false;
            });

            currentPage = 1;
            updateTable();
        };

        // Reset filters to show the original table
        const resetFilters = () => {
            yearFilter.value = "";
            monthFilter.value = "";
            
            // Reapply the current filter and search
            searchTable();
            currentPage = 1;
            updateTable();
        };
        
        document.getElementById("resetFilters").addEventListener("click", resetFilters);

        // Event listener for search input
        searchInput.addEventListener("input", searchTable);

        // Event listener for date filter
        filterButton.addEventListener("click", () => {
            const selectedYear = yearFilter.value;
            const selectedMonth = monthFilter.value;

            if (!selectedYear || !selectedMonth) {
                alert("Please select both a year and a month!");
                return;
            }

            filterTableByDate(selectedYear, selectedMonth);
        });

        // Event listener for pagination buttons
        prevButton.addEventListener("click", () => {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        });

        nextButton.addEventListener("click", () => {
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        });

        // Initialize table and populate year filter
        populateYears();
        updateTable();
    });
</script>
@stop