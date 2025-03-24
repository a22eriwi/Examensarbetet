// ==UserScript==
// @name         Measure script
// @namespace    http://tampermonkey.net/
// @version      2024-09-27
// @description  measureScript
// @author       You
// @match        http://localhost/examensarbete/MongoDB.php
// @grant        GM_xmlhttpRequest
// ==/UserScript==


(function () {
    'use strict';


    //Set total measurements
    const totalMeasurements = 10;
    let i = 0;
    let allMeasurements = 0;

    //Create array with subreddits
    const subreddits = ["AdviceForTeens", "Anxiety"];
    //Create variable searchBar and define it as the searchBar
    const searchBar = document.getElementById("searchBar");
    //Create variable form and define it as the searchForm
    const form = document.getElementById("searchForm");

    async function measureSearchTime() {
        while (i < totalMeasurements) {
            console.log(subreddits[i % subreddits.length]);

            //Save the current element in the array (subbreddit) to a variable
            let subreddit = (subreddits[i % subreddits.length])
            console.log(subreddit);

            //Set the value of the searchBar to the current element in array
            searchBar.value = subreddit;

            // Start timer and save it to var 'measurement1'
            let measurement1 = performance.now();

            // Submit the form
            form.submit();

            // Stop timer and save it to var 'measurement2'
            let measurement2 = performance.now();

            let measurementTime = measurement2 - measurement1;
            let measurementData = subreddit + "," + measurementTime;
            allMeasurements += measurementTime;

            console.log(measurementData);
            console.log(allMeasurements);

            i++;
        }
    }

    measureSearchTime(); // Run the function
})();