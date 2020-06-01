/* eslint-disable no-use-before-define */
import React from "react"
import TextField from "@material-ui/core/TextField"
import Autocomplete from "@material-ui/lab/Autocomplete"

export default function ListOperators() {
    const defaultProps = {
    options: top100Films,
    getOptionLabel: (option: FilmOptionType) => option.title,
    }

    return (
    <div>
        <Autocomplete
            {...defaultProps}
            id="users"
            renderInput={(params) => <div><TextField {...params} margin="normal"/></div>}
        />
    </div>
    )
}

interface FilmOptionType {
    title: string;
}

const top100Films = [
  { title: "The Shawshank Redemption", year: 1994 },
  { title: "The Godfather", year: 1972 },
  { title: "The Godfather: Part II", year: 1974 },
  { title: "The Dark Knight", year: 2008 },
  { title: "Monty Python and the Holy Grail", year: 1975 },
];
