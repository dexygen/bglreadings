let readingsLib = (function() {
  let lib = {
    applyTrends: (readings) => {
      if (readings.length > 1) {
        let lastIndex = readings.length - 1;
        let initReading, prevReading;
        initReading = prevReading = readings[lastIndex].reading;
        readings[lastIndex].trendOverall = readings[lastIndex].trendSincePrior = '';

        for (let i = lastIndex; i-- > 0; ) {
          let R = readings[i];
          R.trendOverall = R.reading - initReading;
          R.trendOverall = R.trendOverall >= 1 ? "+" + R.trendOverall : "" + R.trendOverall;
          R.trendSincePrior = R.reading - prevReading;
          R.trendSincePrior = R.trendSincePrior >= 1 ? "+" + R.trendSincePrior : "" + R.trendSincePrior;
          prevReading = R.reading;
        }
      }
      
      return readings;
    }
  };
  return lib;
})();