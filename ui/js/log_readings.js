class LogReadings extends React.Component {
  constructor(props) {
    super(props);
    this.state = {readings: []};
  }
  
  componentDidMount() {
      ajax("GET", "./api/readings.php?user_id=1", (xhrResponse) => {
        this.setState({readings: (JSON.parse(xhrResponse)).readings});
      }, function() {
        console.log("error");
      });
  }
  
  render() {
    return (
      this.state.readings.map((reading) => {
        return <Reading {...reading} key={"reading-" + reading.reading_id} />
      })
    );
  }
}