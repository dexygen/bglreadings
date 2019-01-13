class LogReadings extends React.Component {
  constructor(props) {
    super(props);
    this.state = {readings: []};
  }
  
  componentDidMount() {
      ajax("GET", "./api/readings.php?user_id=1", (xhrResponse) => {
        this.setState({
          readings: readingsLib.applyTrends((JSON.parse(xhrResponse)).readings)
        });
      }, function() {
        console.log("error");
      });
  }
  
  updateReadings = (readings) => {
    this.setState({readings: readingsLib.applyTrends(readings)});
  }
  
  render() {
    return (
      this.state.readings.map((reading) => {
        return <Reading {...reading} 
                 key={"reading-" + reading.reading_id} 
                 readingId={reading.reading_id} 
                 updateLogReadings={this.updateReadings} />
      })
    );
  }
}