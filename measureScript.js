// ==UserScript==
// @name         Measure script
// @namespace    http://tampermonkey.net/
// @version      2024-09-27
// @description  measureScript
// @author       You
// @match        http://localhost/examensarbete/MongoDB.php
// @grant        GM_xmlhttpRequest
// ==/UserScript==

//Set measurent number
const measurmentCycles = 10;
let i = 0;

//Create array with subreddits
const subreddits = ["AdviceForTeens", "Anxiety"];

//Create variable searchBar and define it as the searchBar
const searchBar = document.getElementById("searchBar");
//Create variable form and define it as the searchForm
const form = document.getElementById("searchForm");

while (measurmentCycles < i ){
    console.log(subreddits[i % subreddits.length]); 

    //Set the value of the searchBar to the current element in array
    searchBar.value = (subreddits[i % subreddits.length]); 

    // Start timer and save it to var 'measurement1'
    let measurement1 = performance.timeOrigin + performance.now();

    // Submit the form
    form.submit();

    // Stop timer and save it to var 'measurement2'
    let measurement2 = performance.timeOrigin + performance.now();
}

