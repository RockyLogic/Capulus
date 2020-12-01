function capitalize_str(param_str) {
    // Function which returns the given string capitalized on its first letter, lowercase on all others
    return param_str.charAt(0).toUpperCase() + param_str.slice(1).toLowerCase();
}

function sanitize_entry(param_str) {
    // Function which returns its trimmed version, also replaced with "N/A" when it comes up empty
    param_str = param_str.trim();
    return param_str ? param_str : "N/A";
}

(function substitute_name() {
    // This function substitutes the session name fields
    const fname_str = capitalize_str(window.sessionStorage.getItem("caps-in-fname"));
    const lname_str = capitalize_str(window.sessionStorage.getItem("caps-in-lname"));
    document.getElementById("name-field").innerHTML = sanitize_entry(fname_str + " " + lname_str);
})();

(function substitute_addresses() {
    // This function substitutes the session address fields
    const addr1_str = window.sessionStorage.getItem("caps-in-address1").split(/ /g).map(capitalize_str).join(' ');
    document.getElementById("address1-field").innerHTML = sanitize_entry(addr1_str);

    const addr2_str = window.sessionStorage.getItem("caps-in-address2").split(/ /g).map(capitalize_str).join(' ');
    document.getElementById("address2-field").innerHTML = sanitize_entry(addr2_str);
})();

(function substitute_regions() {
    // This function substitutes the session region fields
    const city_str = window.sessionStorage.getItem("caps-in-city").split(/ /g).map(capitalize_str).join(' ');
    document.getElementById("city-field").innerHTML = sanitize_entry(city_str);

    const prov_str = window.sessionStorage.getItem("caps-in-province").split(/ /g).map(capitalize_str).join(' ');
    document.getElementById("province-field").innerHTML = sanitize_entry(prov_str);

    const postal_str = window.sessionStorage.getItem("caps-in-postal").split(/ /g).map(word => word.toUpperCase()).join(' ');
    document.getElementById("postal-field").innerHTML = sanitize_entry(postal_str);
})();