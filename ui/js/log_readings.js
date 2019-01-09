class LogReadings extends React.Component {
  constructor(props) {
    super(props);
    this.state = {readings: [{date: '2019-01-06', reading: 160}]};
  }
  
  componentDidMount() {
      ajax("GET", "./api/readings.php?user_id=1", (xhrResponse) => {
        console.log(xhrResponse);
        this.state.readings = [{date: '2019-01-06', reading: 160}]; //JSON.parse(xhrResponse).readings;
      }, function() {
        console.log("error");
      });
  }
  
  render() {
    var K = 0;
    return (
      this.state.readings.map((reading) => {
        return <Reading {...reading} key={"reading-" + ++K} />
      })
    );
  }
}