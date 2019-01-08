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
  
  render() {
    return (
      <div>
        <div id="header-bar">
          <a href="#" onClick={this.toggleModal}>Add Reading</a>
        </div>
        <AddReadingModal show={this.state.isOpen}
          onClose={this.toggleModal}>
          Here's some content for the modal
        </AddReadingModal>
      </div>
    );
  }
}