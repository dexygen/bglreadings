class HeaderBar extends React.Component {
  constructor(props) {
    super(props);
    this.state = { isOpen: false };
  }
  
  toggleModal = () => {
    this.setState({
      isOpen: !this.state.isOpen
    });
  }
  
  saveReading = () => {
    var toggleModal = this.toggleModal.bind(this);
    
    this.setState({mode: "add", user_id: 1}, function() {
      ajax("POST", "./api/readings.php", 
        function() {
          console.log("success2");
        }, 
        function() {
          console.log("error2");
        }, 
        this.state
      );        
    });
  }
  
  updateDate = (dateVal) => {
    this.setState({date: dateVal});
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
        <AddReadingModal show={this.state.isOpen} onClose={this.toggleModal} saveReading={this.saveReading} >
          <h2>Add Reading</h2>
          <form>
              <ReadingDateInput changeHandler={this.updateDate} />
              <div className="form-element">
                  <label>Reading</label><input ref="readingInput" onChange={this.updateReading} />
              </div>
          </form>
          <div>&nbsp;</div>
        </AddReadingModal>
      </div>
    );
  }
}