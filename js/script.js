/* RESIZE EVENT */
/* 
    1000px - Dropdown menue
    800px  - Dropdown at .anotherReservation
    650px  - Hamburger menu for sidebar / Search-Bar shrink
*/

const sidebar = document.querySelector('.sidebar');
const hamburger = document.querySelector('.hamburger');
const nestedUl = document.querySelector('.nested');
const dropdown2 = document.querySelector('.dropdown2');
const search_row2 = document.querySelector('.row-2');

function checkWindowSize() {
    const w = window.innerWidth;
    const hideUl = nestedUl.classList.contains('hide');
    
    const link = document.querySelector('.removalLink');
    const hasLink = link.hasAttribute('href');

    if(w <= 1000) {
        /* HIDE NESTED UL AND REMOVE LINK */
        if(!hideUl) {
            nestedUl.classList.add('hide');
            nestedUl.classList.remove('transition');
        } 

        link.removeAttribute('href');
        dropdownMenu.classList.add('pointer');

    } else {
        /* SHOW NESTED UL AND ADD LINK*/
        if(hideUl) {
            nestedUl.classList.remove('hide');
        } 

        if(!hasLink) {
            link.setAttribute('href', 'reservation.php');
        }
        dropdownMenu.classList.remove('pointer');
    }/* w = 1000px */
    
    if(dropdown2 !== null) {
        const showAnotherReservations = dropdown2.classList.contains('show');

        if(w <= 800) {
            /* HIDE DROPDOWN SIGN AT ANOTHER_RESERVATIONS */
            if(!showAnotherReservations) {
                dropdown2.classList.add('show');
            } 
        } else {
            /* SHOW DROPDOWN SIGN AT ANOTHER_RESERVATIONS */
            if(showAnotherReservations) {
                dropdown2.classList.remove('show');
                dropdown2.classList.remove('transition');
            } 
        } /* w = 800px */   
    }

    const hideSidebar = hamburger.classList.contains('hide');
    

    if(w <= 650) {    
        
        if(!hideSidebar) {
            sidebar.classList.add('hide');
            hamburger.classList.add('hide');
            hamburgerIcon.classList.remove('hide');
            hamburgerIcon.classList.remove('transition');
        }   
        if(search_row2 !== null) {
            const hideSearchbar = search_row2.classList.contains('hide');
            if(!hideSearchbar) {
                search_row2.classList.add('hide');
            }
        }
        
    } else {
        if(hideSidebar) {
            sidebar.classList.remove('hide');
            hamburger.classList.remove('hide');
            hamburgerIcon.classList.add('hide');

            sidebar.classList.remove('transition');
            hamburger.classList.remove('transition');
        }

        if(search_row2 !== null) {
            const hideSearchbar = search_row2.classList.contains('hide');
            if(hideSearchbar) {
                search_row2.classList.remove('hide');
            }
        }   
    }
}

var TO = false;
window.addEventListener('resize', function() {
    /* set timer for resize event */
    if(TO !== false)
        clearTimeout(TO);
    TO = setTimeout(checkWindowSize, 200); //200 is time in miliseconds
});

window.addEventListener('load', checkWindowSize);

/* SIDEBAR */
/* Dropdown menue */
const dropdownMenu = document.querySelector('.dropdownMenu');

function toggleDropdown() {
    const w = window.innerWidth;
    if(w < 1000) {
        const hideItems = nestedUl.classList.contains('hide');
        const sidebar = document.querySelector('.sidebar');

        if(!hideItems) {
            nestedUl.classList.add('hide');
            nestedUl.classList.remove('transition');
            sidebar.classList.remove('open');
        } else {
            nestedUl.classList.remove('hide');
            sidebar.classList.add('open');
            nestedUl.classList.add('transition');
        }
    } 
}

dropdownMenu.addEventListener('click', toggleDropdown);

/* Hamburger menu */
const hamburgerIcon = document.querySelector('.hamburgerIcon');

hamburgerIcon.addEventListener('click', function() {
    const hideSidebar = hamburger.classList.contains('hide');

    if(!hideSidebar) {
        sidebar.classList.add('hide');
        sidebar.classList.remove('transition');
        hamburger.classList.add('hide');
        hamburger.classList.remove('transition');
    } else {
        sidebar.classList.remove('hide');
        sidebar.classList.add('transition');
        hamburger.classList.remove('hide');
        hamburger.classList.add('transition');
    }
    
});

/* SEARCH BAR */
const searchInput = document.getElementById('searchText');
if(searchInput !== null) {
    searchInput.addEventListener('input', showAllSearchBar);
    searchInput.addEventListener('blur', hideSearchBar);

    function showAllSearchBar(e) {
        const hideSearchbar = search_row2.classList.contains('hide');
        if(hideSearchbar) {
            search_row2.classList.remove('hide');
            search_row2.classList.add('transition');
        } 
    }

    function hideSearchBar(e) {
        const hideSearchbar = search_row2.classList.contains('hide');
        const searchInputValue = e.target.value;
        if(!hideSearchbar && searchInputValue === "") {
            search_row2.classList.add('hide');
            search_row2.classList.add('transition');
        } 
    }
}

// check All checkbox
const selectAllBoxes = document.getElementById('selectAllBoxes');

if(selectAllBoxes !== null) {
    selectAllBoxes.addEventListener('change', selectAllcheckBoxes);
}

function selectAllcheckBoxes() {
    const checkBoxes = document.querySelectorAll('.checkbox');
    checkBoxes.forEach(checkBox => {
        if(selectAllBoxes.checked) {
            checkBox.checked = true;
        } else {
            checkBox.checked = false;
        }
    });
}


// CLOSE BTN
const closeBtns = document.querySelectorAll('.closeBtn');
if(closeBtns !== null) {
    closeBtns.forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            closeBtn.parentElement.classList.add('hide');
        });
    });
    
}



// DETAILS.PHP
    // Show scroll down mark when contents is too long
    const container = document.querySelector('.mail');
    if(container !== null) {
        var containerHeight = container.clientHeight;
        containerHeight = containerHeight - 40;

        const contents = document.querySelector('.mail-contents');
        var contentsHeight = contents.clientHeight;
        contentsHeight = contentsHeight + 60;

        if(contentsHeight > containerHeight) {
            const downArea = document.querySelector('.down');
            downArea.classList.remove('hide');

            const downMark = document.querySelector('.down .fa-angle-down');

            const option = { once: true };

            downMark.addEventListener('click', scrollAndHideDownmark, option);
            container.addEventListener('scroll', scrollAndHideDownmark, option);
            document.querySelector('.reservationDetails').addEventListener('scroll', scrollAndHideDownmark, option);

            function scrollAndHideDownmark() {
                container.scrollTo(0, contentsHeight);
                downArea.classList.add('hide');
            }   
        }   
    }

    /* Toggle Dropdown anotherReservation by click */ 
    if(dropdown2 !== null) {
        dropdown2.addEventListener('click', function() {
            const anotherReservation = document.querySelector('.anotherReservation');
            const showAnotherReservations = anotherReservation.classList.contains('open');
            if(showAnotherReservations) {
                anotherReservation.classList.remove('open');
                anotherReservation.classList.remove('transition');
            } else {
                anotherReservation.classList.add('open');
                anotherReservation.classList.add('transition');
            }
        });
    }


/* ADD REQUEST */
    // make sure when past date was selected
    const date = document.getElementById('date')


    if(date !== null){
        date.addEventListener('change', function() {
            var today = new Date();
            var dateValue = new Date(date.value);

            if(today > dateValue) {
                window.alert('Are you sure this Reservation was past Event?');
            }
        });
    }


    //Check all required fields are filled
    const addForm = document.getElementById('add');
    if(addForm !== null) {
        addForm.addEventListener('submit', checkRequiredFields);
    }


    function checkRequiredFields(event) {
        const errorMessage = document.querySelector('.message');

        var requestEmailValue = document.getElementById('email').value;
        var requestTelValue = document.getElementById('tel').value;

        if(requestEmailValue.length == 0 && requestTelValue.length == 0) {
            errorMessage.innerHTML = "Please enter Email address or Phone number";
            errorMessage.classList.add('alert'); 
            errorMessage.classList.remove('hide');

            event.preventDefault();
        } 
    } 

/* SEARCHBOX.PHP */
const searchBtn = document.getElementById('searchBtn');

if(searchBtn !== null ) {

    // check input is not empty
    searchBtn.addEventListener('click', function(e) {
        const searchText = document.getElementById('searchText').value;
        const searchCategory = document.getElementById('searchCategory').value;

        const searchBar = document.querySelector('.search-bar');

        if(searchText === "" || searchCategory === "") {
            searchBar.style.border = "1px solid tomato";
            e.preventDefault();
        } else {
            searchBar.style.border = "1px solid #ddd";
        }
    });
    
    // drop down add filter field
    const addFilter = document.getElementById('addFilter');

    addFilter.addEventListener('click', function() {
        document.getElementById('filterForm').classList.toggle('hide');
    });

     // CHECK ONLY ONE CHECKBOX
     // flag
    const flag1 = document.getElementById('flag1');
    const flag2 = document.getElementById('flag2');
     
    flag1.addEventListener('change', function() {
        if(flag1.checked) {
            flag2.checked = false;
        }
    });
 
    flag2.addEventListener('change', function() {
        if(flag2.checked) {
            flag1.checked = false;
        }
    });

    // upcoming event
    const upcoming = document.getElementById('upcoming');
    const past = document.getElementById('past');
     
    upcoming.addEventListener('change', function() {
        if(upcoming.checked) {
            past.checked = false;
        }
    });
 
    past.addEventListener('change', function() {
        if(past.checked) {
            upcoming.checked = false;
        }
    });

    // status
    const unread = document.getElementById('unread');
    const pending = document.getElementById('pending');
    const confirmed = document.getElementById('confirmed');
    const canceled = document.getElementById('canceled');

    const statuses = [unread, pending, confirmed, canceled];

    statuses.forEach(selected => {
        selected.addEventListener('change', () => {
            if(selected === unread) {
                pending.checked = false;
                confirmed.checked = false;
                canceled.checked = false;
            } else if(selected === pending) {
                unread.checked = false;
                confirmed.checked = false;
                canceled.checked = false;
            } else if(selected === confirmed) {
                unread.checked = false;
                pending.checked = false;
                canceled.checked = false;
            } else if(selected === canceled) {
                unread.checked = false;
                pending.checked = false;
                confirmed.checked = false;
            }
        });
    });
     
    // clear all filters
    const clearBtn = document.getElementById('clearBtn');
    clearBtn.addEventListener('click', ()=> {
        const allFilters = document.querySelectorAll('#filterForm input[type=checkbox]');
        allFilters.forEach(filter => {
            filter.checked = false;
        });
    });
} // end of searchbox.php


    



