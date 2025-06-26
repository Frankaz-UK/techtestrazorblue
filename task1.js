// Task 1
function isAnagram(str1, str2) {
    const cleanString = (str) => str.replace(/[^a-z]/gi, '').toLowerCase();
    const sorted = (str) => cleanString(str).split('').sort().join('');
    return sorted(str1) === sorted(str2);
}

alert(isAnagram('dormitory', 'dirty room')); // true
alert(isAnagram('dormitorz', 'dirty room')); // false
alert(isAnagram('funeral', 'real fun')); // true
alert(isAnagram('joeseph', 'real fun')); // false