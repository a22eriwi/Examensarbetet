// ==UserScript==
// @name         Measure script
// @namespace    http://tampermonkey.net/
// @version      2024-09-27
// @description  measureScript
// @author       You
// @match        http://localhost/examensarbetet/MongoDB.php
// @match        http://localhost/examensarbetet/Couchbase.php
// @match        http://localhost/examensarbetet/MySQL.php
// @grant        GM_xmlhttpRequest
// ==/UserScript==

(function () {
    'use strict';

    const seed = 42423;

    //Seed
    function mulberry32(seed) {
        return function() {
            let t = seed += 0x6D2B79F5;
            t ^= t + Math.imul(t ^ t >>>15, t | 1);
            t ^= t + Math.imul(t ^ t >>>7, t | 61);
            return((t ^ t >>> 14) >>> 0) /4294967296;
        };
    }

    //Randomize array function
    function randomizeArray(array, seed) {
        const random = mulberry32(seed);
        const shuffled = [...array];
        for (let i = shuffled.length - 1; i > 0; i--){
            const j = Math.floor(random() * (i + 1));
            [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
        }
        return shuffled;
    }

    //Set total measurements
    const totalMeasurements = 28;

    //Create two variables, one for the current measurement cycle and one that has all the measurements
    let measurementIndex = parseInt(localStorage.getItem("measurementIndex") || "0");
    let allMeasurements = localStorage.getItem("allMeasurements") || "";

    //Create array with subreddits
    const subreddits = ["AdviceForTeens", "Anxiety", "ApplyingToCollege", "astrology", "business", "careerguidance", "college", "Colombia", "computer_science", "COVID19", "dating", "depression", "employment", "engineering", "Entrepreneur", "feminism", "GradSchool", "kidsrights", "Mexico_spanishlanguage", "NeutralPolitics", "povertyfinance", "science", "SuicideWatch", "teenagers", "whatsbotheringyou", "YouthandGovernment", "youthshouldknow", "YouthRights"];

    let order = JSON.parse(localStorage.getItem("order") || null);

    //Randomize the subreddits with the seed
    if (!order) {
        order = randomizeArray(subreddits, seed);
        localStorage.setItem("order", JSON.stringify(order));
    }

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

            //Create a string that contains stordedSubbreddit and the measurement time
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
            let subreddit = (order[measurementIndex % order.length]);

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
            // Save the measurements to CSV file and download it
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