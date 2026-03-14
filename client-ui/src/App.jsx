import "./assets/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "./App.css";
import { BrowserRouter, Route, Routes } from "react-router";
import Navbar from "./components/Navbar";
import Decks from "./pages/Decks";
import NewDeck from "./pages/NewDeck";

function App() {
    return (
        <>
            <BrowserRouter>
                <Navbar/>
				<Routes>
					<Route path="/" element={<Decks />} />
					<Route path="/new-deck" element={<NewDeck />} />
				</Routes>
            </BrowserRouter>
		</>
    );
}

export default App;
