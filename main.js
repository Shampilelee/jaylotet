
// FOOTER
let yr = new Date().getFullYear();
document.getElementById('year').innerHTML = `© ` + yr;



// FIND ITEM - AUTOCOMPLETE
let debounceTimeout;
const debounce = (func, delay) => {
    return function(...args) {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => func.apply(this, args), delay);
    };
};

// HIDE SUGGESTION LIST FROM DISPLAYING
document.getElementById('suggestions').style.display = "none";

const fetchSuggestions = debounce(function() {
    const query = this.value;
    
    // CHECKING IF USER HAS ENTERED A VALUE INTO "find_Txt"
    if (query.length > 0) {

        // DISPLAY SUGGESTION LIST WHEN USER ENTERS VALUE.
        document.getElementById('suggestions').style.display = "block";


        // FETCHING FROM "autocomplete.php"
        fetch(`autocomplete.php?query=${encodeURIComponent(query)}`)
            // THEN CONVERT RETRIVED DATA INTO JSON FORMAT.
            .then(response => response.json())
            // THEM WORK WITH RETRIVED DATA
            .then(data => {
                const suggestions = document.getElementById('suggestions');
                suggestions.innerHTML = '';

                // CHECKING IF DATA HAS BEEN RETRIVED FROM "autocomplete.php".
                if (data.length > 0) {
                    
                    // FOR EACH ITEM/DATA RETRIVED FROM "autocomplete.php", CREATE A LIST(li),
                    // ASSIGN THE RETRIVED ITEM TO THE LIST.
                    data.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = item;

                        li.addEventListener('click', () => {
                            document.getElementById('find_Txt').value = item;
                            suggestions.innerHTML = '';
                            
                            // HIDE SUGGESTION LIST FROM DISPLAYING
                            document.getElementById('suggestions').style.display = "none";
                        });
                        suggestions.appendChild(li);
                    });

                } else {
                    const li = document.createElement('li');
                    li.textContent = 'No Item Found';
                    suggestions.appendChild(li);
                }
            })
            .catch(error => {
                console.error('Error fetching suggestions:', error);
            });
            
    } else {
        document.getElementById('suggestions').innerHTML = '';

        // HIDE SUGGESTION LIST FROM DISPLAYING
        document.getElementById('suggestions').style.display = "none";
    }

}, 300);

// LET THE "find_Txt" FIELD LISTEN FOR INPUT FROM USER.
document.getElementById('find_Txt').addEventListener('input', fetchSuggestions);



// ADD ITEM
const item_type = document.getElementById("item_type");

        const container = document.getElementById("choices");
        const category_label = document.getElementById("show_catgory_lbel");

        const hair = document.getElementById("hair");
        const spray = document.getElementById("spray");
        const cream = document.getElementById("cream");
        const oil = document.getElementById("oil");
        const others = document.getElementById("others");

        setInterval(() => {

            if (item_type.value == "Hair") {
                console.log("entered hair");
                category_label.textContent = "Category";

                // TURN DISPLAY ON
                container.style.display = "flex";
                container.style.justifyContent = "center";
                container.style.alignItems = "center";

                // HIDE THIS
                spray.style.display = "none";
                spray.required = false;
                spray.name = "asd";
                spray.value = "";

                cream.style.display = "none";
                cream.required = false;
                cream.name = "dsa";
                cream.value = "";

                oil.style.display = "none";
                oil.required = false;
                oil.name = "dsa";
                oil.value = "";

                others.style.display = "none";
                others.required = false;
                others.name = "dsa";
                others.value = "";

                hair.required = true;
                hair.name = "item_category";
                hair.style.display = "flex";
                console.log("passed hair");
            
            } else if (item_type.value == "Perfume") {
                console.log("entered perfume");
                category_label.textContent = "Category";

                container.style.display = "flex";
                container.style.justifyContent = "center";
                container.style.alignItems = "center";

                hair.style.display = "none";
                hair.required = false;
                hair.name = "dsa";
                hair.value = "";

                cream.style.display = "none";
                cream.required = false;
                cream.name = "dsa";
                cream.value = "";

                oil.style.display = "none";
                oil.required = false;
                oil.name = "dsa";
                oil.value = "";

                others.style.display = "none";
                others.required = false;
                others.name = "dsa";
                others.value = "";

                spray.required = true;
                spray.name = "item_category";
                spray.style.display = "flex";
                console.log("passed perfume");

            } else if (item_type.value == "Cream") {
                console.log("entered hair");
                category_label.textContent = "Category";

                // TURN DISPLAY ON
                container.style.display = "flex";
                container.style.justifyContent = "center";
                container.style.alignItems = "center";

                // HIDE THIS
                spray.style.display = "none";
                spray.required = false;
                spray.name = "asd";
                spray.value = "";

                hair.style.display = "none";
                hair.required = false;
                hair.name = "dsa";
                hair.value = "";

                oil.style.display = "none";
                oil.required = false;
                oil.name = "dsa";
                oil.value = "";

                others.style.display = "none";
                others.required = false;
                others.name = "dsa";
                others.value = "";

                cream.required = true;
                cream.name = "item_category";
                cream.style.display = "flex";
                console.log("passed hair");

            } else if (item_type.value == "Oil") {
                console.log("entered hair");
                category_label.textContent = "Category";

                // TURN DISPLAY ON
                container.style.display = "flex";
                container.style.justifyContent = "center";
                container.style.alignItems = "center";

                // HIDE THIS
                spray.style.display = "none";
                spray.required = false;
                spray.name = "asd";
                spray.value = "";

                hair.style.display = "none";
                hair.required = false;
                hair.name = "dsa";
                hair.value = "";

                cream.style.display = "none";
                cream.required = false;
                cream.name = "dsa";
                cream.value = "";

                others.style.display = "none";
                others.required = false;
                others.name = "dsa";
                others.value = "";

                oil.required = true;
                oil.name = "item_category";
                oil.style.display = "flex";
                console.log("passed hair");

            } else if (
                item_type.value == "Hair Dye" || 
                item_type.value == "Hair Spray" || 
                item_type.value == "Shower Gel" || 
                item_type.value == "Concentrated Serum" || 
                item_type.value == "Sun Block C" || 
                item_type.value == "Soap" || 
                item_type.value == "Powder" ||
                item_type.value == "Shampoo / Conditioner" || 
                item_type.value == "Hair Relaxer" || 
                item_type.value == "Hair WAX / GEL" || 
                item_type.value == "Cleaner" || 
                item_type.value == "Pain Releaver" || 
                item_type.value == "Body Repair" ||
                item_type.value == "Eye Lashes" ||
                item_type.value == "NAIL" || 
                item_type.value == "Singlet" ||
                item_type.value == "Boxer" ||
                item_type.value == "Tools"

            ) {

                console.log("entered hair");
                category_label.textContent = "Category";

                // TURN DISPLAY ON
                container.style.display = "flex";
                container.style.justifyContent = "center";
                container.style.alignItems = "center";

                // HIDE THIS
                spray.style.display = "none";
                spray.required = false;
                spray.name = "asd";
                spray.value = "";

                hair.style.display = "none";
                hair.required = false;
                hair.name = "dsa";
                hair.value = "";

                cream.style.display = "none";
                cream.required = false;
                cream.name = "dsa";
                cream.value = "";

                oil.style.display = "none";
                oil.required = false;
                oil.name = "dsa";
                oil.value = "";

                others.required = true;
                others.name = "item_category";
                others.style.display = "flex";
                console.log("passed hair");

            } else {
                // TURN DISPLAY OFF
                container.style.display = "none";
                console.log("container display off");
                category_label.textContent = "...";
            }

        }, 500);






