@extends('layouts.dashboard')

@section('CSS')
<!-- Add this to your CSS -->
<style>
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
                        <h6 class="font-weight-semibold text-lg mb-0">Packages list</h6>
                        <p class="text-sm">See information about all Packages</p>
                    </div>
                </div>
            </div>
            <!-- Confirmation Modal -->
            <div id="delete-modal" class="modal">
                <div class="modal-content">
                    <h3>Confirm Deletion</h3>
                    <p>Are you sure you want to delete this Package ?</p>
                    <div class="modal-buttons">
                        <button id="confirm-delete" class="btn-confirm">Confirm</button>
                        <span id="loader" class="loader" style="display: none;"></span>
                        <button id="cancel-delete" class="btn-cancel">Cancel</button>
                    </div>
                </div>
            </div>
            <!-- Confirmation Modal -->
            <div class="card-body px-0 py-0">
                <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input id="filter-all" type="radio" class="btn-check" name="btnradiotable" autocomplete="off" checked>
                        <label class="btn btn-white px-3 mb-0" for="filter-all">All</label>
                        <input id="filter-basic" type="radio" class="btn-check" name="btnradiotable" autocomplete="off">
                        <label class="btn btn-white px-3 mb-0" for="filter-basic">Basic</label>
                        <input id="filter-half_board" type="radio" class="btn-check" name="btnradiotable" autocomplete="off">
                        <label class="btn btn-white px-3 mb-0" for="filter-half_board">Half Board</label>
                        <input id="filter-full_course" type="radio" class="btn-check" name="btnradiotable" autocomplete="off">
                        <label class="btn btn-white px-3 mb-0" for="filter-full_course">Full Course</label>
                    </div>
                    <div class="py-3 px-3 d-sm-flex align-items-center">
                        <!-- Date Filtration -->
                        <select id="yearFilter" class="form-select" style="width: 150px;">
                            <option value="" selected>Year</option>
                            <!-- Populate with years dynamically -->
                        </select>

                        <select id="monthFilter" class="form-select" style="width: 150px;">
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
                    <table class="table align-items-center mb-0" id="PackagesTable">
                        <thead class="bg-gray-100">
                            <tr style="text-align: center;">
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">By Company</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">For User</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Package Name</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">From City</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">To City</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Number of Nights</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Price / Person</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Hotel Name</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Discription</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Reservation Type</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Is Cruise</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Created At</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Ends At</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $key => $package)
                            <tr data-status="@if($package->reservation_type == 1){{'basic'}}@elseif($package->reservation_type == 2){{'half_board'}}@elseif($package->reservation_type == 3){{'full_course'}}@endif" data-company-id="{{ $package->id }}" id="row-{{$package->id}}">
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex align-items-center">
                                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm rounded-circle me-2" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center ms-1">
                                            <h6 class="mb-0 text-sm font-weight-semibold">{{ $package->company->name }}</h6>
                                            <p class="text-sm text-secondary mb-0">{{ $package->company->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        @if($package->User)
                                        <div class="d-flex flex-column justify-content-center ms-1">
                                            <h6 class="mb-0 text-sm font-weight-semibold">{{ $package->User->name }}</h6>
                                            <p class="text-sm text-secondary mb-0">{{ $package->User->email }}</p>
                                        </div>
                                        @else 
                                        <div class="d-flex flex-column justify-content-center ms-1">
                                            <h6 class="mb-0 text-sm font-weight-semibold">General</h6>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center ms-1">
                                            <h6 class="mb-0 text-sm font-weight-semibold">{{ $package->name }}</h6>
                                            <p class="text-sm text-secondary mb-0">{{ $package->name_ar }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm text-dark font-weight-semibold mb-0">From: {{ $package->From->name }}</p>
                                </td>
                                <td>
                                    <p class="text-sm text-dark font-weight-semibold mb-0">To: {{ $package->To->name }}</p>
                                </td>
                                <td>
                                    <p class="text-sm text-dark text-center font-weight-semibold mb-0">{{ $package->no_of_nights }}</p>
                                </td>
                                <td>
                                    <p class="text-sm text-dark text-center font-weight-semibold mb-0">{{ $package->price_per_person }}</p>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center ms-1">
                                            <h6 class="mb-0 text-sm font-weight-semibold">{{ $package->hotel_name }}</h6>
                                            <p class="text-sm text-secondary mb-0">{{ $package->hotel_name_ar }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm text-dark font-weight-semibold mb-0">{{ $package->description }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    @if($package->reservation_type == 1)
                                    <span class="badge badge-sm border border-secondary text-secondary bg-secondary reservation">
                                        Basic
                                    </span>
                                    @elseif($package->reservation_type == 2)
                                    <span class="badge badge-sm border border-warning text-warning bg-warning reservation">
                                        Half Board
                                    </span>
                                    @elseif($package->reservation_type == 3)
                                    <span class="badge badge-sm border border-success text-success bg-success reservation">
                                        Full Course
                                    </span>
                                    @endif
                                </td>
                                <td class="align-middle text-center text-sm">
                                    @if($package->is_cruise)
                                    <span class="badge badge-sm border border-primary text-primary bg-primary">
                                        Cruise
                                    </span>
                                    @else
                                    <span class="badge badge-sm border border-info text-info bg-info">
                                        Regular
                                    </span>
                                    @endif
                                </td>
                                <td class="align-middle text-center" data-date="{{ $package->created_at->toDateString() }}">
                                    <span class="text-secondary text-sm font-weight-normal">{{ $package->created_at->toDateString() }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-sm font-weight-normal">{{ $package->end_date ? date("Y-m-d", strtotime($package->end_date)) : "" }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs m-2 delete cursor-pointer" data-bs-toggle="tooltip" data-bs-title="Delete Package">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </a>
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
        const filterAll        = document.getElementById("filter-all");
        const filterBasic      = document.getElementById("filter-basic");
        const filterHalfBoard  = document.getElementById("filter-half_board");
        const filterFullCourse = document.getElementById("filter-full_course");

        const searchInput      = document.getElementById("searchInput");
        const table            = document.getElementById("PackagesTable");
        const tableRows        = Array.from(table.querySelectorAll("tbody tr"));
    
        const yearFilter       = document.getElementById("yearFilter");
        const monthFilter      = document.getElementById("monthFilter");
        const filterButton     = document.getElementById("filterByDate");
    
        const pageInfo         = document.querySelector(".paging");
        const prevButton       = document.querySelector(".previous");
        const nextButton       = document.querySelector(".next");

        let filteredRows  = [...tableRows]; // Rows currently visible (filtered or searched)
        let currentFilter = "all"; // Current filter type
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

        // Filter table by type (e.g., all, basic)
        const filterTable = filterType => {
            currentFilter = filterType;
            filteredRows = tableRows.filter(row => {
                const status = row.getAttribute("data-status");
                return filterType === "all" || status === filterType;
            });

            // Apply search on top of the filtered rows
            searchTable();

            currentPage = 1;
            updateTable();
        };

        // Search table within the current filtered rows
        const searchTable = () => {
            const query = searchInput.value.toLowerCase().trim();
            filteredRows = tableRows.filter(row => {
                const status = row.getAttribute("data-status");
                const packageName = row.cells[2].textContent.toLowerCase();
                const matchesFilter = currentFilter === "all" || status === currentFilter;
                const matchesSearch = packageName.includes(query);

                return matchesFilter && matchesSearch;
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
            filterTable(currentFilter);
            searchTable();
            currentPage = 1;
            updateTable();
        };

        // Event listener for filter buttons
        filterAll.addEventListener("click", () => filterTable("all"));
        filterBasic.addEventListener("click", () => filterTable("basic"));
        filterHalfBoard.addEventListener("click", () => filterTable("half_board"));
        filterFullCourse.addEventListener("click", () => filterTable("full_course"));
        
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

    // Variables for the modal and buttons
    const deleteModal = document.getElementById('delete-modal');
    const confirmDeleteButton = document.getElementById('confirm-delete');
    const cancelDeleteButton = document.getElementById('cancel-delete');
    const loader = document.getElementById('loader');

    // Store the company ID to delete
    let packageIdToDelete = null;

    // Add event listener to the delete buttons
    document.querySelectorAll('.delete').forEach(tag => {
        tag.addEventListener('click', function () {
            // Get the company ID
            packageIdToDelete = this.closest('tr').dataset.packageId;

            // Show the modal
            deleteModal.style.display = 'flex';
        });
    });

    // Handle the confirm button click
    confirmDeleteButton.addEventListener('click', function () {
        if (packageIdToDelete) {
            // Show loader and hide the confirm button
            confirmDeleteButton.style.display = 'none';
            loader.style.display = 'inline-block';

            // Send POST request to delete the company
            fetch('/api/package/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ package_id: packageIdToDelete })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // On success, remove the row from the table
                    const row = document.getElementById(`row-${packageIdToDelete}`);
                    row.remove();
                } else {
                    // Handle failure case
                    alert('Failed to delete company');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                // Hide the modal and reset loader and confirm button
                deleteModal.style.display = 'none';
                loader.style.display = 'none';
                confirmDeleteButton.style.display = 'inline-block';
                packageIdToDelete = null;
            });
        }
    });

    // Handle the cancel button click
    cancelDeleteButton.addEventListener('click', function () {
        // Hide the modal and reset the ID
        deleteModal.style.display = 'none';
        packageIdToDelete = null;
    });
</script>
@stop