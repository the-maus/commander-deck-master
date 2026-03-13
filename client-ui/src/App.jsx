import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import "./App.css";
import { BrowserRouter } from "react-router";
import Navbar from "./components/Navbar";

function App() {
	return (
		<div className="App">
			<BrowserRouter>
				<Navbar />
			</BrowserRouter>
		</div>
	);
}

export default App;
