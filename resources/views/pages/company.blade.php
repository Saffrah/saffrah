@extends('layouts.dashboard')

@section('CSS')
<!-- Add this to your CSS -->
<style>
    
</style>
@stop

@section('breadcrumbData')
    <div id="page-data" data-company-name="{{ $company->name ?? '' }}"></div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border shadow-xs mb-5">
            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">{{ $company->name }} Company</h6>
                        <p class="text-sm">See information about {{$company->name}} Company</p>
                    </div>
                </div>
            </div>

            <div class="card-body px-0 py-0">
                <div class="border-bottom py-3 px-3">
                    <!-- Company -->
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 mb-xl-0">
                            <div class="card border shadow-xs mb-4">
                                <div class="card-body text-start p-3 w-100">
                                    <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M7.5 5.25a3 3 0 013-3h3a3 3 0 013 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0112 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 017.5 5.455V5.25zm7.5 0v.09a49.488 49.488 0 00-6 0v-.09a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5zm-3 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                            <path d="M3 18.4v-2.796a4.3 4.3 0 00.713.31A26.226 26.226 0 0012 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 01-6.477-.427C4.047 21.128 3 19.852 3 18.4z" />
                                        </svg>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="w-100">
                                                <p class="text-sm text-secondary mb-1">Total Packages</p>
                                                <h4 class="mb-2 font-weight-bold" id="totalPackagesCard">{{ $packages->count() }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0">
                            <div class="card border shadow-xs mb-4">
                                <div class="card-body text-start p-3 w-100">
                                    <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M4.5 3.75a3 3 0 00-3 3v.75h21v-.75a3 3 0 00-3-3h-15z" />
                                            <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 003 3h15a3 3 0 003-3v-7.5zm-18 3.75a.75.75 0 01.75-.75h6a.75.75 0 010 1.5h-6a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="w-100">
                                                <p class="text-sm text-secondary mb-1">Total Revenue</p>
                                                <h4 class="mb-2 font-weight-bold" id="totalIncomeCard">${{ $packages->sum('total_purchased') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0">
                            <div class="card border shadow-xs mb-4">
                                <div class="card-body text-start p-3 w-100">
                                    <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h12a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm4.5 7.5a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0v-2.25a.75.75 0 01.75-.75zm3.75-1.5a.75.75 0 00-1.5 0v4.5a.75.75 0 001.5 0V12zm2.25-3a.75.75 0 01.75.75v6.75a.75.75 0 01-1.5 0V9.75A.75.75 0 0113.5 9zm3.75-1.5a.75.75 0 00-1.5 0v9a.75.75 0 001.5 0v-9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="w-100">
                                                <p class="text-sm text-secondary mb-1">Company Commission</p>
                                                <h4 class="mb-2 font-weight-bold" id="companyCommission" data-commission="{{$company->percentage/100}}">{{ $company->percentage }}%</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card border shadow-xs mb-4">
                                <div class="card-body text-start p-3 w-100">
                                    <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 00-3 3v4.318a3 3 0 00.879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 005.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 00-2.122-.879H5.25zM6.375 7.5a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="w-100">
                                                <p class="text-sm text-secondary mb-1">Net Income</p>
                                                <h4 class="mb-2 font-weight-bold" id="systemRevenueCard">${{ (($company->percentage/100)*$packages->sum('total_purchased')) }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Company Packages -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border shadow-xs mb-4">
                                <div class="card-header border-bottom pb-0">
                                    <div class="d-sm-flex align-items-center mb-4">
                                        <div>
                                            <h6 class="font-weight-semibold text-lg mb-0">{{ $company->name }} Packages</h6>
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
                                                <tr data-status="@if($package->reservation_type == 1){{'basic'}}@elseif($package->reservation_type == 2){{'half_board'}}@elseif($package->reservation_type == 3){{'full_course'}}@endif" data-company-id="{{ $package->id }}" id="row-{{$package->id}}" data-total-purchased="{{ $package->total_purchased }}">
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
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('JavaScript')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const companyName           = "{{ $company->name ?? '' }}";
        
        const filterAll             = document.getElementById("filter-all");
        const filterBasic           = document.getElementById("filter-basic");
        const filterHalfBoard       = document.getElementById("filter-half_board");
        const filterFullCourse      = document.getElementById("filter-full_course");

        const searchInput           = document.getElementById("searchInput");
        const table                 = document.getElementById("PackagesTable");
        const tableRows             = Array.from(table.querySelectorAll("tbody tr"));

        const yearFilter            = document.getElementById("yearFilter");
        const monthFilter           = document.getElementById("monthFilter");
        const filterButton          = document.getElementById("filterByDate");

        const pageInfo              = document.querySelector(".paging");
        const prevButton            = document.querySelector(".previous");
        const nextButton            = document.querySelector(".next");

        const totalIncomeCard       = document.getElementById("totalIncomeCard");
        const totalPackagesCard     = document.getElementById("totalPackagesCard");
        const systemRevenueCard     = document.getElementById("systemRevenueCard");

        let filteredRows = [...tableRows]; // Rows currently visible (filtered or searched)
        let currentFilter = "all"; // Current filter type
        let currentPage = 1;
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
            const endIndex   = currentPage * rowsPerPage;

            tableRows.forEach(row => (row.style.display = "none")); // Hide all rows
            filteredRows.slice(startIndex, endIndex).forEach(row => (row.style.display = "")); // Show only rows for the current page

            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
            prevButton.disabled = currentPage === 1;
            nextButton.disabled = currentPage === totalPages || totalPages === 0;

            // Update statistics on the cards
            updateStats(filteredRows);
        };

        // Filter table by type (e.g., all, basic)
        const filterTable = filterType => {
            currentFilter = filterType;
            filteredRows  = tableRows.filter(row => {
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

        // Update the statistics on the four cards
        const updateStats = (filteredRows) => {
            let totalIncome       = 0;
            let totalPackages     = 0;
            let systemRevenue     = 0;

            filteredRows.forEach(row => {
                const totalPurchased = parseFloat(row.getAttribute("data-total-purchased")) || 0; // Get total_purchased from row attribute
                
                totalIncome += totalPurchased; // Assuming total_income is total_purchased for the given row
                totalPackages++; // Increment total packages count (each row represents a package)
            });
            // Select the <h4> element using its id
            const element = document.getElementById('companyCommission');
            // Get the value of the data-commission attribute
            const commission = element.getAttribute('data-commission');

            systemRevenue = totalIncome * commission; // Assuming 20% revenue to the system
            
            // Update the card values
            totalIncomeCard.textContent    = `$${totalIncome.toFixed(2)}`;
            totalPackagesCard.textContent  = `${totalPackages}`;
            systemRevenueCard.textContent  = `$${systemRevenue.toFixed(2)}`;
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
</script>
@stop
