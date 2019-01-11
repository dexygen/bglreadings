class HeaderBar extends React.Component {
  constructor(props) {
    super(props);
    this.state = { isOpen: false };
  }
  
  toggleModal = () => {
    this.setState({
      isOpen: !this.state.isOpen
    }, () => {
      if (this.state.isOpen) {
        // TODO: clean up mess
        this.updateDate(this.refs.readingDate.refs.dateInput.value);
      }
    });
  }
  
  saveReading = () => {
    this.setState({mode: "add", user_id: 1}, () => {
      ajax("POST", "./api/readings.php", 
        (xhrResponse) => {
          this.setState({isOpen: false});
          this.props.updateLogReadings(JSON.parse(xhrResponse).readings);
        }, 
        () => {
          console.log("error2");
        }, 
        this.state
      );        
    });
  }
 
  componentDidMount = () => {
    this.updateDate((new Date()).toISOString().substr(0,10));
  }
  
  updateDate = (dateVal) => {
    this.setState({reading_date: dateVal});
  }
  
  updateReading = () => {
    this.setState({reading: this.refs.readingInput.value});
  }
  
  render() {
    return (
      <div>
        <div id="header-bar">
          <a href="#" onClick={this.toggleModal}>Add Reading</a>
        </div>
        <SaveReadingModal 
            show={this.state.isOpen} 
            onClose={this.toggleModal} 
            saveReading={this.saveReading} 
            saveMode="Add">
          <form>
              <ReadingDateInput ref="readingDate" changeHandler={this.updateDate} />
              <div className="form-element">
                  <label>Reading</label><input ref="readingInput" onChange={this.updateReading} />
              </div>
          </form>
        </SaveReadingModal>
      </div>
    );
  }
}