// ==UserScript==
// @name         Measure script
// @namespace    http://tampermonkey.net/
// @version      2024-09-27
// @description  measureScript
// @author       You
// @match        http://localhost/examensarbete/MongoDB.php
// @match        http://localhost/examensarbete/Couchbase.php
// @match        http://localhost/examensarbete/MySQL.php
// @grant        GM_xmlhttpRequest
// ==/UserScript==

(function () {
    'use strict';

    //Set total measurements
    const totalMeasurements = 10;

    //Create two variables, one for the current measurement cycle and one that has all the measurements
    let measurementIndex = parseInt(localStorage.getItem("measurementIndex") || "0");
    let allMeasurements = localStorage.getItem("allMeasurements") || "";

    //Create array with subreddits
    const subreddits = ["AdviceForTeens", "Anxiety"];

    //All code inside this function will only execute when the page is fully loaded
    window.addEventListener("load", function () {

        //Save the id of the form and searchbar to variables
        const searchBar = document.getElementById("searchBar");
        const form = document.getElementById("searchForm");

        //Create variables in order to retrieve from localStorage 
        let storedStartTime = parseFloat(localStorage.getItem("measurementStartTime") || "0");
        let storedSubreddit = localStorage.getItem("measurementSubreddit");

        if (storedStartTime) {
            // Take new time stamp and save to variable
            let measurement2 = performance.timeOrigin + performance.now();

            //Calculate the difference between latest and first timestamp
            let measurementTime = measurement2 - storedStartTime;

            //Create a string that contains stordedSubbreddit and the mea
            let measurementData = `${storedSubreddit},${measurementTime.toFixed(2)}\n`;
            allMeasurements += measurementData;

            //Sets the local storage "allMeasurements" to the current measurements that exist
            localStorage.setItem("allMeasurements", allMeasurements);

            //Adds +1 to the measurementIndex
            measurementIndex++;

            //Sets current measurementIndex (Measure cycle)
            localStorage.setItem("measurementIndex", measurementIndex);
        }
        if (measurementIndex < totalMeasurements) {
            //Save the current element in the array (subbreddit) to a variable
            let subreddit = (subreddits[measurementIndex % subreddits.length]);

            //Set the value of the searchBar to the current element in array
            searchBar.value = subreddit;

            // Start timer and save it to 'measurement1'
            let measurement1 = performance.timeOrigin + performance.now();

            localStorage.setItem("measurementStartTime", measurement1);
            localStorage.setItem("measurementSubreddit", subreddit);

            // Submit the form
            form.submit();
        }
        else {
            // Make anchor and click it
            var anchor = document.createElement("a");
            var dataBlob = new Blob([allMeasurements], { type: "text/csv" });
            var objUrl = URL.createObjectURL(dataBlob);
            anchor.href = objUrl;
            anchor.download = "data.csv";
            document.body.appendChild(anchor);
            anchor.click();

            localStorage.clear();
        }
    });
})();